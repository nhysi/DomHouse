package ephec.domhouse;

import java.util.ArrayList;

import android.os.Bundle;
import android.app.ActionBar;
import android.app.Activity;
import android.app.Fragment;
import android.app.FragmentManager;
import android.content.Intent;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.support.v4.widget.DrawerLayout;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.ArrayAdapter;
import android.widget.ListView;
public class MainActivity extends Activity {
	ArrayList<String> menuList = new ArrayList<String>();
	String[] menu;

	DrawerLayout dLayout;
	ListView dList;
	ArrayAdapter<String> adapter;
	
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.activity_main);
		ActionBar bar = getActionBar();
		bar.setDisplayHomeAsUpEnabled(true);
		
		importerPieces();
		menuList.add("Déconnexion");
		
		menu = new String[menuList.size()];
		menuList.toArray(menu);
		
		dLayout = (DrawerLayout) findViewById(R.id.drawer_layout);
		dLayout.setScrimColor(getResources().getColor(android.R.color.transparent)); //enleve ombre navigation drawer
		dList = (ListView) findViewById(R.id.left_drawer);
		adapter = new ArrayAdapter<String>(this,android.R.layout.simple_list_item_1,menu);
		dList.setAdapter(adapter);
		dList.setSelector(android.R.color.holo_blue_dark);		
		
		dList.setOnItemClickListener(new OnItemClickListener(){
			@Override
			public void onItemClick(AdapterView<?> arg0, View v, int position, long id) {
				if(position == menu.length-1){ //Si appui sur "Deconnexion" qui est dernier élément
					finish();
				}
				else{
					dLayout.closeDrawers();
					Bundle args = new Bundle();
					args.putString("Menu", menu[position]);
					Fragment detail = new DetailFragment(getApplicationContext());
					detail.setArguments(args);
					FragmentManager fragmentManager = getFragmentManager();
					fragmentManager.beginTransaction().replace(R.id.content_frame, detail).commit();
				}
			}
		});
		dLayout.openDrawer(dList);
	}
	public void importerPieces(){
//import du nom de toutes les  pièces et stockage dans menuList
		menuList.add("Salon");
		menuList.add("Garage");
		menuList.add("Salle à manger");
		menuList.add("Salle de bain");
		menuList.add("Toilettes");
	}
	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
	    switch (item.getItemId()) {
	    case android.R.id.home:
	    	if(!dLayout.isDrawerOpen(dList)) dLayout.openDrawer(dList);
	    	else dLayout.closeDrawers();
	        return true;
	    default:
	        return super.onOptionsItemSelected(item);
	    }
	}
}