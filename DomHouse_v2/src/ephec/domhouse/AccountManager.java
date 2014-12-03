package ephec.domhouse;

import java.util.ArrayList;
import java.util.List;
 





import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import android.os.Parcelable;
 
public class AccountManager {
     
    private Web web;
     
    private static String URL = "http://www.nhysi.com/api/";// http://domhouse.zapto.org:82/Raspberry/api.php
     
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
        return web.getFromURL(URL, params);
    }
    
    public ArrayList<Equipement> getEquipement(String room) throws JSONException{
    	ArrayList<Equipement> r = new ArrayList<Equipement>();
    	List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("tag", "getDevice"));
        params.add(new BasicNameValuePair("room", room));
        JSONObject e = web.getFromURL(URL, params);
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
        System.out.println(r.get(1).toString());
        return r;
    }
    
    public void setPin(int pin,int state){
        List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("tag", "setDevice"));
        params.add(new BasicNameValuePair("pin", Integer.toString(pin)));
        params.add(new BasicNameValuePair("value", Integer.toString(state)));
        web.getFromURL(URL, params);
    }
    /**
     
    public boolean isUserLoggedIn(Context context){
        DatabaseHandler db = new DatabaseHandler(context);
        int count = db.getRowCount();
        if(count > 0){
            // user logged in
            return true;
        }
        return false;
    }*/
     
    /**
    
    public boolean logoutUser(Context context){
        DatabaseHandler db = new DatabaseHandler(context);
        db.resetTables();
        return true;
    }*/
     
}
