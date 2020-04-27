package com.reportingTocontrolRoom.reporting;

import androidx.appcompat.app.AppCompatActivity;

import android.os.Bundle;
import android.webkit.WebView;
import android.webkit.WebViewClient;

public class SubActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_sub);
        getSupportActionBar().hide();

        WebView webView = (WebView) findViewById(R.id.webView);
        String uni = getIntent().getStringExtra("URL");
        webView.loadUrl(uni);
        webView.setWebViewClient(new WebViewClient());
    }
}
