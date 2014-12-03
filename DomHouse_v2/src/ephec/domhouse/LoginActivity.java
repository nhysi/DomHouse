package ephec.domhouse;

import org.json.JSONException;
import org.json.JSONObject;






//import android.support.v7.app.ActionBarActivity;
import android.text.Html;
import android.text.method.LinkMovementMethod;
import android.util.Log;
import android.app.ActionBar;
import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.os.Bundle;
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
	TextView noConnection = null;
	public final static String EXTRA_MESSAGE = "remote.MESSAGE";
	AccountManager account;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_login);
		
		ActionBar bar = getActionBar();
		bar.hide();
		
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
			wrongPass = (TextView)findViewById(R.id.wrongpwd);
			noConnection = (TextView)findViewById(R.id.noConnection);
			wrongPass.setVisibility(View.INVISIBLE);
			noConnection.setVisibility(View.INVISIBLE);
			if(!isNetworkAvailable(LoginActivity.this)){
				noConnection.setVisibility(View.VISIBLE);
    	    } else {
    	    	account = new AccountManager();
    	    	Thread thread = new Thread(new Runnable(){
    	    	    @Override
    	    	    public void run() {
    	    	        try {
    	    	        	String user = username.getText().toString();
    	    		    	String pass = password.getText().toString();
    	    	        	JSONObject r = account.login(user, pass);
    	    	        	try {
    	    					if(r.getBoolean("success")){
    	    						wrongPass.setVisibility(View.INVISIBLE);
    	    						// Authentification OK, changement d'activity
    	    						System.out.println("auth : OK !");
    	    						
    	    						Intent intent = new Intent(LoginActivity.this, MainActivity.class);
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
	    	
	    	
	    
	    	
			
		}
    	
    };
    // https://code.google.com/p/android-drwable/source/browse/trunk/IsNetWorkAvailable/src/com/example/IsNetworkAvailable/IsNetworkAvailable.java?r=10
    public static boolean isNetworkAvailable( Activity mActivity ) 
    { 
            Context context = mActivity.getApplicationContext();
            ConnectivityManager connectivity = (ConnectivityManager) context.getSystemService(Context.CONNECTIVITY_SERVICE);
            
            if (connectivity == null){   
            	Log.d("isNetworkAvailable"," connectivity == null");
            	return false;
            } else {  
            	Log.d("isNetworkAvailable"," connectivity != null");
          
          NetworkInfo[] info = connectivity.getAllNetworkInfo();   
          if (info == null){
        	  Log.d("isNetworkAvailable"," info == null");
        	  return false;
          } else {   
                  Log.d("isNetworkAvailable"," info != null");
                  for (int i = 0; i <info.length; i++) 
                  { 
                          if (info[i].getState() == NetworkInfo.State.CONNECTED)
                          {
                                  return true; 
                          }
                          else
                                  Log.d("isNetworkAvailable"," info["+i+"] != connected");
                  }
                  return false;
           } 
                  
       }   
            
   } 
}
