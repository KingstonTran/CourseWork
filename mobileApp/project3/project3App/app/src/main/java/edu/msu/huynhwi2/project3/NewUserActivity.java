package edu.msu.huynhwi2.project3;

import androidx.appcompat.app.AppCompatActivity;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.os.Looper;
import android.util.Xml;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import org.xmlpull.v1.XmlPullParser;
import org.xmlpull.v1.XmlPullParserException;

import java.io.IOException;
import java.io.InputStream;

public class NewUserActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
    }


    public void onCreate1(View view)
    {
        EditText firstInput = findViewById(R.id.eduser);
        EditText secondInput = findViewById(R.id.passwordwrite);
        EditText thirdInput = findViewById(R.id.confirmpassword);
        final String user =  firstInput.getText().toString();
        final String password = secondInput.getText().toString();
        final String confirmation = thirdInput.getText().toString();

        if(user.equals("") || password.equals("")){
            Toast(getString(R.string.registerEmpty));
        }
        if (password.equals(confirmation))
        {
            onRegister(view, user, password);
        }else
        {
            Toast newToast = Toast.makeText(getApplicationContext(), "PASSWORDS DO NOT MATCH, USER NOT CREATED!", Toast.LENGTH_SHORT);
            newToast.show();
        }


    }
    public void Toast(String print)
    {
        Context context= getApplicationContext();
        int timer = Toast.LENGTH_LONG;
        Toast toast = Toast.makeText(context, print, timer);
        toast.show();
    }
    public void toMain(){
//        Toast newToast = Toast.makeText(getApplicationContext(), "CONGRATS YOU MADE A NEW USER!", Toast.LENGTH_SHORT);
        Intent intent = new Intent(this, MainActivity.class);
        startActivity(intent);
        finish();
    }
    public void onCancel(final View view)
    {
        Toast newToast = Toast.makeText(getApplicationContext(), "USER CREATION CANCELED", Toast.LENGTH_SHORT);
        newToast.show();
        setContentView(R.layout.activity_login);
    }

    public void onRegister(final View view, final String user, final String password){

        new Thread(new Runnable() {
            @Override
            public void run() {
                Cloud cloud = new Cloud();
                final boolean saved = cloud.register(user, password);
                Looper.prepare();

                if(!saved){
                    view.post(new Runnable() {
                        @Override
                        public void run() {

                            Toast("Username already exists");

                        }
                    });
                } else if(saved){
                    toMain();
                }

            }
        }).start();

    }


}
