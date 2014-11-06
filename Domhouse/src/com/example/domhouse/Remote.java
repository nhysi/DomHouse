package com.example.domhouse;

import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.ActionBarActivity;
import android.text.Html;
import android.text.method.LinkMovementMethod;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;


public class Remote extends ActionBarActivity {
	
	Button login = null;
	EditText username = null;
	EditText password = null;
	TextView wrongPass = null;
	public final static String EXTRA_MESSAGE = "remote.MESSAGE";
	
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_remote);
        
        
        login = (Button)findViewById(R.id.loginButton);
        username = (EditText)findViewById(R.id.UserEditText);
        password = (EditText)findViewById(R.id.passwordEditText);
        wrongPass = (TextView)findViewById(R.id.wrongpwd);
        ((TextView) findViewById(R.id.dontHaveAccountTextView)).setMovementMethod(LinkMovementMethod.getInstance());
        ((TextView) findViewById(R.id.dontHaveAccountTextView)).setText(Html.fromHtml(getResources().getString(R.string.donthave_account_textview_html)));
        ((TextView) findViewById(R.id.forgotpasswordtextView)).setMovementMethod(LinkMovementMethod.getInstance());
        ((TextView) findViewById(R.id.forgotpasswordtextView)).setText(Html.fromHtml(getResources().getString(R.string.forgot_password_textview_html)));

        login.setOnClickListener(logListener);
    }

    private OnClickListener logListener = new OnClickListener() {
    	
		@Override
		public void onClick(View v) {
			String user = username.getText().toString();
	    	String pass = password.getText().toString();

	    	if(user.equals("ephec") && pass.equals("ephec")){
	    		wrongPass.setVisibility(View.INVISIBLE);
	    		// Authentification OK, changement d'activity
	    		System.out.println("auth : OK !");
	    		
	    		Intent intent = new Intent(Remote.this, Remote_tab.class);
	    	    intent.putExtra(EXTRA_MESSAGE, user);
	    	    startActivity(intent);
	    	}else{
	    		wrongPass.setVisibility(View.VISIBLE);
	    		System.out.println("Wrong pwd");
	    	}
			
		}
    	
    };
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.remote, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();
        if (id == R.id.action_settings) {
            return true;
        }
        return super.onOptionsItemSelected(item);
    }
    
}
