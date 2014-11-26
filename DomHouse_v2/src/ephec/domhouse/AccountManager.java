package ephec.domhouse;

import java.util.ArrayList;
import java.util.List;
 




import org.apache.http.NameValuePair;
import org.apache.http.message.BasicNameValuePair;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
 
public class AccountManager {
     
    private Web web;
     
    private static String URL = "http://www.nhysi.com/api/";
     
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
    	JSONArray a;
    	ArrayList<Equipement> r = new ArrayList<Equipement>();
    	List<NameValuePair> params = new ArrayList<NameValuePair>();
        params.add(new BasicNameValuePair("tag", "getDevice"));
        params.add(new BasicNameValuePair("room", room));
        JSONObject e = web.getFromURL(URL, params);
        //System.out.println(e.toString());
        JSONArray recs = e.getJSONArray(room);
        for (int i = 0; i < recs.length(); ++i) {
            JSONObject rec = recs.getJSONObject(i);
            //int pin = rec.getInt("pin");
            String name = rec.getString("name");
            boolean value = rec.getBoolean("value");
            r.add(new Equipement(name, value));
        }
        return null;
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
