package ephec.domhouse;

import java.util.ArrayList;
import java.util.List;
 






import java.util.concurrent.CountDownLatch;

import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.os.HandlerThread;
import android.os.Parcelable;
 
public class AccountManager {
     
    private Web web;
    private JSONObject e;
     
    public String URL = "http://www.nhysi.com/api/";// http://domhouse.zapto.org:82/Raspberry/api.php
     
    public AccountManager(){
        web = new Web();
    }
     
    /**
     * function make Login Request
     * @param email
     * @param password
     * */
    public JSONObject login(String name, String password){
        List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("tag", "login"));
        params.add(new BasicNameValuePair("name", name));
        params.add(new BasicNameValuePair("password", password));
        return ask(URL, params);
    }
    
    public ArrayList<Equipement> getEquipement(String room) throws JSONException{
    	ArrayList<Equipement> r = new ArrayList<Equipement>();
    	List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("tag", "getDevice"));
        params.add(new BasicNameValuePair("room", room));
       
        e = ask(URL, params);
        //System.out.println(e.toString());
        JSONArray recs = e.getJSONArray("room");
        for (int i = 0; i < recs.length(); ++i) {
            JSONObject rec = recs.getJSONObject(i);
            int pin = rec.optInt("pin");
            String name = rec.optString("name");
            boolean value = rec.optBoolean("value");
            boolean editable = rec.optBoolean("editable");
            r.add(new Equipement(name, value,pin,editable));
        }
        //System.out.println(r.get(1).toString());
        return r;
    }
    public ArrayList<String> getRoom() throws JSONException{
    	ArrayList<String> menuList = new ArrayList<String>();
    	List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("tag", "getRoom"));
        
        e = ask(URL, params);
		//System.out.println(e.toString());
        JSONArray recs = e.getJSONArray("room");
        for (int i = 0; i < recs.length(); ++i) {
            JSONObject rec = recs.getJSONObject(i);
            menuList.add(rec.optString("name"));
        }
      //System.out.println(menuList);
    	return menuList;
    }
    public void setPin(int pin,int state){
        List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("tag", "setDevice"));
        params.add(new BasicNameValuePair("pin", Integer.toString(pin)));
        params.add(new BasicNameValuePair("value", Integer.toString(state)));
        e = ask(URL, params);
    }
     private JSONObject ask(final String URL,final List<NameValuePair> p){
         final CountDownLatch latch = new CountDownLatch(1);
         Thread uiThread = new HandlerThread("UIHandler"){
 	        @Override
 	        public void run(){
 	            e = web.getFromURL(URL, p);
 	            latch.countDown(); // Release await() in the test thread.
 	        }
 	    };
 	    uiThread.start();
 	    try {
 			latch.await();
 		} catch (InterruptedException e1) {
 			// TODO Auto-generated catch block
 			e1.printStackTrace();
 		}
 	    return e;
     }
    /**
    
    public boolean logoutUser(Context context){
        DatabaseHandler db = new DatabaseHandler(context);
        db.resetTables();
        return true;
    }*/
     
}
