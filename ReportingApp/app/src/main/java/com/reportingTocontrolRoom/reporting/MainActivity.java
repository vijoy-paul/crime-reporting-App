package com.reportingTocontrolRoom.reporting;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import android.Manifest;
import android.content.Context;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Build;
import android.os.Bundle;
import android.telephony.TelephonyManager;
import android.view.View;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.EditText;
import android.widget.Toast;

import java.net.SocketException;

public class MainActivity extends AppCompatActivity {


    EditText desc, land;
    Button location, Submit;
    CheckBox police, fire, ambu;

    TelephonyManager tm;
    String IMEI=" ";


    String polchk = "NO", ambchk = "NO", firchk = "NO";


    @RequiresApi(api = Build.VERSION_CODES.M)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        getSupportActionBar().hide();

        desc = (EditText) findViewById(R.id.txtDesc);
        land = (EditText) findViewById(R.id.txtLand);

        location = (Button) findViewById(R.id.SelectLocation);
        Submit = (Button) findViewById(R.id.btnSubmit);
        police = (CheckBox) findViewById(R.id.chkPolice);
        ambu = (CheckBox) findViewById(R.id.chkAmbu);
        fire = (CheckBox) findViewById(R.id.chkFire);

        tm = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
        if (checkSelfPermission(Manifest.permission.READ_PHONE_STATE) != PackageManager.PERMISSION_GRANTED) {
            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.READ_PHONE_STATE}, PackageManager.PERMISSION_GRANTED);
            return;
        }

        IMEI = tm.getDeviceId();




    }

    public void loc(View v) {

        Intent intent = new Intent(MainActivity.this, MapsActivity.class);
        startActivity(intent);
    }


    public void sub(View v)  {
        try {
            String ap = getIntent().getStringExtra("LOC");
//            String Lat = "";
//            String Long = "";
            String Lat = "123456789"; //temp
            String Long = "123456789"; //temp
//            int i, j;
//
//            for (i = 10; ap.charAt(i) != ','; i++) {
//                Lat += ap.charAt(i);
//            }
//
//            for (i = i + 1; ap.charAt(i) != ')'; i++) {
//                Long += ap.charAt(i);
//            }


            String description = desc.getText().toString();
            String landmark = land.getText().toString();

            String preq = polchk;
            String freq = firchk;
            String areq = ambchk;
            String Idimei = IMEI;

            //String androidID = System.getString(this.getContentResolver(), Settings.Secure.ANDROID_ID);

           // Toast.makeText(MainActivity.this,Idimei, Toast.LENGTH_SHORT).show();
            String mainUrl = "http://192.168.43.150/dcr/submit.php?";
            String param = "POL='" + preq + "'&AMBU='" + areq + "'&FIR='" + freq + "'&LAT='" + Lat + "'&LONG='" + Long + "'&LAND='" + landmark + "'&DES='" + description + "'&imei='" + Idimei + "'";
            Intent intent1 = new Intent(MainActivity.this, SubActivity.class);
            String uarl = mainUrl + param;
            intent1.putExtra("URL", uarl);
            startActivity(intent1);
        }
        catch (Exception e)
        {
            e.printStackTrace();
        }

    }

    public void pol(View v) {
        if (police.isChecked())
            polchk = "YES";
        else
            polchk = "NO";
    }

    public void amb(View v) {
        if (ambu.isChecked())
            ambchk = "YES";
        else
            ambchk = "NO";
    }

    public void fir(View v) {
        if (fire.isChecked())
            firchk = "YES";
        else
            firchk = "NO";
    }




}
