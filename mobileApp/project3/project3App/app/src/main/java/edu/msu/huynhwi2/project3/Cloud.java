package edu.msu.huynhwi2.project3;

import android.util.Log;
import android.util.Xml;

import org.xmlpull.v1.XmlPullParser;
import org.xmlpull.v1.XmlPullParserException;
import org.xmlpull.v1.XmlSerializer;

import java.io.IOException;
import java.io.InputStream;
import java.io.OutputStream;
import java.io.StringWriter;
import java.io.UnsupportedEncodingException;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLEncoder;

public class Cloud {
    private static final String REGISTER_URL = "http://webdev.cse.msu.edu/~tranking/cse476/project3/register.php";
    private static final String LOGIN_URL = "http://webdev.cse.msu.edu/~tranking/cse476/project3/login.php";
    private static final String UTF8 = "UTF-8";
    private static final String MAGIC = "NechAtHa6RuzeR8x";

    public boolean register(String user, String password) {
        user = user.trim();
        if (user.length() == 0) {
            return false;
        }

        password = password.trim();
        if (password.length() == 0) {
            return false;
        }

        XmlSerializer xml = Xml.newSerializer();
        StringWriter writer = new StringWriter();

        try {
            xml.setOutput(writer);

            xml.startDocument("UTF-8", true);

            xml.startTag(null, "neighborhoodtunerds");

            xml.attribute(null, "magic", MAGIC);
            xml.attribute(null, "user", user);
            xml.attribute(null, "password", password);

            xml.endTag(null, "neighborhoodtunerds");

            xml.endDocument();

        } catch (IOException e) {
            // This won't occur when writing to a string
            return false;
        }

        final String xmlStr = writer.toString();
        /*
         * Convert the XML into HTTP POST data
         */
        String postDataStr;
        try {
            postDataStr = "xml=" + URLEncoder.encode(xmlStr, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            return false;
        }

        /*
         * Send the data to the server
         */
        byte[] postData = postDataStr.getBytes();

        InputStream stream = null;
        try {
            URL url = new URL(REGISTER_URL);

            HttpURLConnection conn = (HttpURLConnection) url.openConnection();

            conn.setDoOutput(true);
            conn.setRequestMethod("POST");
            conn.setRequestProperty("Content-Length", Integer.toString(postData.length));
            conn.setUseCaches(false);

            OutputStream out = conn.getOutputStream();
            out.write(postData);
            out.close();

            int responseCode = conn.getResponseCode();
            if (responseCode != HttpURLConnection.HTTP_OK) {
                return false;
            }

            /*BufferedReader reader = new BufferedReader(new InputStreamReader(conn.getInputStream()));
            String line;
            while ((line = reader.readLine()) != null) {
                Log.i("hatter", line);
            }
            */

            stream = conn.getInputStream();

            /**
             * Create an XML parser for the result
             */
            try {
                XmlPullParser xmlR = Xml.newPullParser();
                xmlR.setInput(stream, UTF8);

                xmlR.nextTag();      // Advance to first tag
                xmlR.require(XmlPullParser.START_TAG, null, "neighborhoodtunerds");

                String status = xmlR.getAttributeValue(null, "status");
                String msg = xmlR.getAttributeValue(null, "msg");
                if (status.equals("no")) {
                    return false;
                }

                // We are done
            } catch (XmlPullParserException ex) {
                return false;
            } catch (IOException ex) {
                return false;
            }

        } catch (MalformedURLException e) {
            return false;
        } catch (IOException ex) {
            return false;
        } finally {
            if (stream != null) {
                try {
                    stream.close();
                } catch (IOException ex) {
                    // Fail silently
                }
            }
        }


        return true;
    }

    /**
     * Open a connection to a user in the cloud.
     * @param user     username string
     * @param password password string
     * @return reference to an input stream or null if this fails
     */
    public InputStream login(String user, String password) {
        String login = LOGIN_URL + "?magic=" + MAGIC + "&user=" + user + "&password=" + password;
        try {
            URL url = new URL(login);
            HttpURLConnection conn = (HttpURLConnection) url.openConnection();
            int responseCode = conn.getResponseCode();
            if (responseCode != HttpURLConnection.HTTP_OK) {
                Log.e("login", "Failed to login, response code is = " + responseCode);
                return null;
            }

            InputStream stream = conn.getInputStream();

            return stream;
        } catch (IOException e) {
            Log.e("login", "Exception occurred while logging in!", e);
            return null;
        }
    }
}