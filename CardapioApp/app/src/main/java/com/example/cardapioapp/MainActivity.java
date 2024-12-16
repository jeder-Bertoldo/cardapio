package com.example.cardapioapp;

import android.annotation.SuppressLint;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.webkit.ValueCallback;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AlertDialog;
import androidx.appcompat.app.AppCompatActivity;

public class MainActivity extends AppCompatActivity {

    private WebView webView;
    private ValueCallback<Uri[]> filePathCallback;
    private static final int FILE_CHOOSER_REQUEST_CODE = 1;

    @SuppressLint("SetJavaScriptEnabled")
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        webView = findViewById(R.id.webView);

        // Configura o WebView para lidar com navegação e upload de arquivos
        webView.setWebViewClient(new WebViewClient());
        webView.setWebChromeClient(new WebChromeClient() {
            @Override
            public boolean onShowFileChooser(WebView webView, ValueCallback<Uri[]> filePathCallback, FileChooserParams fileChooserParams) {
                MainActivity.this.filePathCallback = filePathCallback;
                Intent intent = new Intent(Intent.ACTION_GET_CONTENT);
                intent.addCategory(Intent.CATEGORY_OPENABLE);
                intent.setType("image/*");
                startActivityForResult(Intent.createChooser(intent, "Selecione uma imagem"), FILE_CHOOSER_REQUEST_CODE);
                return true;
            }
        });

        // Configurações do WebView
        WebSettings webSettings = webView.getSettings();
        webSettings.setJavaScriptEnabled(true);
        webSettings.setDomStorageEnabled(true);

        // Substitua pelo IP do servidor local
        webView.loadUrl("http://172.16.1.90/cardapio/");
    }

    // Lida com o resultado do seletor de arquivos
    @Override
    protected void onActivityResult(int requestCode, int resultCode, @Nullable Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == FILE_CHOOSER_REQUEST_CODE && resultCode == RESULT_OK) {
            if (data != null && filePathCallback != null) {
                filePathCallback.onReceiveValue(new Uri[]{data.getData()});
                filePathCallback = null;
            }
        } else if (filePathCallback != null) {
            filePathCallback.onReceiveValue(null);
            filePathCallback = null;
        }
    }

    // Intercepta o botão voltar para navegar no WebView
    @Override
    public void onBackPressed() {
        if (webView.canGoBack()) {
            webView.goBack(); // Volta para a página anterior
        } else {
            // Exibe uma mensagem de confirmação antes de sair
            new AlertDialog.Builder(this)
                    .setTitle("Sair do aplicativo")
                    .setMessage("Tem certeza que deseja sair?")
                    .setPositiveButton("Sim", (dialog, which) -> super.onBackPressed())
                    .setNegativeButton("Não", null)
                    .show();
        }
    }
}
