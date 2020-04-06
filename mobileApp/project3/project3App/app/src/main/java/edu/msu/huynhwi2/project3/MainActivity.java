package edu.msu.huynhwi2.project3;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Looper;
import android.util.Xml;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ArrayAdapter;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Spinner;
import android.widget.Toast;

import org.xmlpull.v1.XmlPullParser;
import org.xmlpull.v1.XmlPullParserException;

import java.io.IOException;
import java.io.InputStream;

public class MainActivity extends AppCompatActivity {

    private EditText firstInput;
    private EditText secondInput;

    @Override
    public void onBackPressed() {
        //Do nothing
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
        firstInput = findViewById(R.id.username);
        secondInput = findViewById(R.id.password);

    }
    public void onLogin(final View view) {

        final String user =  firstInput.getText().toString();
        final String password = secondInput.getText().toString();


        if(user.equals("") || password.equals("")){
            Toast("You need a username and password to play!");
        }else{

            new Thread(new Runnable() {
                @Override
                public void run() {

                    Cloud cloud = new Cloud();
                    InputStream stream = cloud.login(user, password);
                    Looper.prepare();

                    boolean success=false;

                    if(stream!=null){
                        /**
                         * Create an XML parser for the result
                         */
                        try {
                            XmlPullParser xmlR = Xml.newPullParser();
                            xmlR.setInput(stream, "UTF-8");

                            xmlR.nextTag();      // Advance to first tag
                            xmlR.require(XmlPullParser.START_TAG, null, "neighborhoodtunerds");

                            String status = xmlR.getAttributeValue(null, "status");
                            if(status.equals("yes")) {

                                success=true;
                                toMap();
                            } else {
                                success = false;
                            }

                            // We are done
                        } catch(XmlPullParserException ex) {
                            success = false;

                        } catch(IOException ex) {

                            success = false;

                        } finally {
                            try {
                                stream.close();
                            } catch (IOException e) {

                            }
                        }
                    }
                    if(!success){
                        view.post(new Runnable() {
                            @Override
                            public void run() {

                                Toast("Incorrect login information");

                            }
                        });

                    }


                }
            }).start();

        }

    }

    public void Toast(String print)
    {
        Context context= getApplicationContext();
        int timer = Toast.LENGTH_LONG;
        Toast toast = Toast.makeText(context, print, timer);
        toast.show();
    }

    public void onCreateUser(View view)
    {
        Intent intent = new Intent(this, NewUserActivity.class);
        startActivity(intent);
        finish();
    }

    private void toMap(){

        Intent intent = new Intent(this, MapsActivity.class);
        startActivity(intent);
        finish();

    }
}
