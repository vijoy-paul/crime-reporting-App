package com.reportingTocontrolRoom.reporting;

import androidx.core.app.ActivityCompat;
import androidx.fragment.app.FragmentActivity;
import android.content.Intent;

import android.Manifest;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationListener;
import android.location.LocationManager;
import android.os.Bundle;
import android.view.View;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.BitmapDescriptorFactory;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

public class MapsActivity extends FragmentActivity implements OnMapReadyCallback {

    private GoogleMap mMap;
    private LocationListener locationListener;
    private LocationManager locationManager;
    private final long MIN_TIME=1000;
    private final long MIN_DIST=5;
    private LatLng latLng;
    Marker mCurrLocationMarker;

    String ap;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_maps);


        // Obtain the SupportMapFragment and get notified when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, PackageManager.PERMISSION_GRANTED);
        ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_COARSE_LOCATION}, PackageManager.PERMISSION_GRANTED);

    }



    @Override
    public void onMapReady(GoogleMap googleMap) {
        mMap = googleMap;



        locationListener =new LocationListener() {
            @Override
            public void onLocationChanged(Location location) {

                if (mCurrLocationMarker != null) {
                    mCurrLocationMarker.remove();
                }


                latLng  = new LatLng(location.getLatitude(),location.getLongitude());
                MarkerOptions markerOptions = new MarkerOptions();
                markerOptions.position(latLng);
                markerOptions.title("Current Position");
                markerOptions.icon(BitmapDescriptorFactory.defaultMarker(BitmapDescriptorFactory.HUE_RED));
                mCurrLocationMarker = mMap.addMarker(markerOptions);
                // mMap.addMarker(new MarkerOptions().position(latLng).title("Current location"));
                mMap.moveCamera(CameraUpdateFactory.newLatLng(latLng));
                mMap.moveCamera(CameraUpdateFactory.zoomTo(15f));

                ap = latLng.toString();



            }

            @Override
            public void onStatusChanged(String provider, int status, Bundle extras) {

            }

            @Override
            public void onProviderEnabled(String provider) {

            }

            @Override
            public void onProviderDisabled(String provider) {

            }
        };

        locationManager = (LocationManager) getSystemService(LOCATION_SERVICE);
        try{

            locationManager.requestLocationUpdates(LocationManager.NETWORK_PROVIDER,MIN_TIME,MIN_DIST,locationListener);
            locationManager.requestLocationUpdates(LocationManager.GPS_PROVIDER,MIN_TIME,MIN_DIST,locationListener);

           }
        catch (SecurityException e)
          {
            e.printStackTrace();
          }


    }
    public void Confirm(View view)
    {
        Intent intent2 = new Intent(getBaseContext(), MainActivity.class);

        intent2.putExtra("LOC", ap);
        intent2.addFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
        //onBackPressed();
        startActivity(intent2);
        //finish();
    }
}
