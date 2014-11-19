package ephec.domhouse;

import org.json.JSONException;
import org.json.JSONObject;

//import android.support.v7.app.ActionBarActivity;
import android.text.Html;
import android.text.method.LinkMovementMethod;
import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;

public class LoginActivity extends Activity {

	Button login = null;
	EditText username = null;
	EditText password = null;
	TextView wrongPass = null;
	public final static String EXTRA_MESSAGE = "remote.MESSAGE";
	AccountManager account;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);
		
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
			
	    	
	    	account = new AccountManager();
	    	Thread thread = new Thread(new Runnable(){
	    	    @Override
	    	    public void run() {
	    	        try {
	    	        	String user = username.getText().toString();
	    		    	String pass = password.getText().toString();
	    	        	JSONObject r = account.login(user, pass);
	    	        	wrongPass = (TextView)findViewById(R.id.wrongpwd);
	    	        	try {
	    					if(r.getBoolean("success")){
	    						wrongPass.setVisibility(View.INVISIBLE);
	    						// Authentification OK, changement d'activity
	    						System.out.println("auth : OK !");
	    						
	    						Intent intent = new Intent(LoginActivity.this, MainActivity.class);
	    					    intent.putExtra(EXTRA_MESSAGE, user);
	    					    startActivity(intent);
	    					}else{
	    						wrongPass.setVisibility(View.VISIBLE);
	    						System.out.println("Wrong pwd");
	    					}
	    				} catch (JSONException e) {
	    					// TODO Auto-generated catch block
	    					e.printStackTrace();
	    				}
	    	        } catch (Exception e) {
	    	            e.printStackTrace();
	    	        }
	    	    }
	    	});
	    	thread.start(); 
	    
	    	
			
		}
    	
    };

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		// Inflate the menu; this adds items to the action bar if it is present.
		getMenuInflater().inflate(R.menu.login, menu);
		return true;
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		// Handle action bar item clicks here. The action bar will
		// automatically handle clicks on the Home/Up button, so long
		// as you specify a parent activity in AndroidManifest.xml.
		int id = item.getItemId();
		/*if (id == R.id.action_settings) {
			return true;
		}*/
		return super.onOptionsItemSelected(item);
	}
}
