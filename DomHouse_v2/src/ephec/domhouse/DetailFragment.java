package ephec.domhouse;
import java.util.ArrayList;
import java.util.concurrent.CountDownLatch;

import org.json.JSONException;

import android.app.Fragment;
import android.content.Context;
import android.content.Intent;
import android.graphics.Color;
import android.os.Bundle;
import android.os.HandlerThread;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.LinearLayout;
import android.widget.Switch;
import android.widget.TextView;
public class DetailFragment extends Fragment {
	TextView text;
	Context context;
	ArrayList<Equipement> equip;

	public DetailFragment(Context contextAct)
	{
		context = contextAct;
	}
	@Override
	public View onCreateView(LayoutInflater inflater,ViewGroup container, Bundle args) {
		View view = inflater.inflate(R.layout.menu_detail_fragment, container, false);
		String menu = getArguments().getString("Menu");
	
		text= (TextView) view.findViewById(R.id.detail);
		text.setText(menu);

		equip = new ArrayList<Equipement>();
		chargementEquipements(menu);

		LinearLayout ll = (LinearLayout) view.findViewById(R.id.linLay);
		for (int i=0; i<equip.size(); i++) {

				if(!equip.get(i).isModifiable()){ //Si l'équipement n'est pas modifiable, on crée un textview à la place d'un switch
					TextView textview1 = new TextView(context);
					textview1.setText(equip.get(i).getNom());
					textview1.setTextSize(25);
					textview1.setPadding(30, 25, 30, 25); //left, top, right, bottom
					if(equip.get(i).isEtat()) textview1.setTextColor(Color.parseColor("#07A671"));
					else textview1.setTextColor(Color.parseColor("#A6073C"));
					ll.addView(textview1); // Attache le textview au layout parent
				}
				else{
					Switch switch1 = new Switch(context);
					switch1.setText(equip.get(i).getNom());
					switch1.setTextSize(25);
					switch1.setTextColor(Color.parseColor("#7C9DA9"));
					switch1.setPadding(30, 25, 30, 25); //left, top, right, bottom
					switch1.setTextOn("On");
					switch1.setTextOff("Off");
					if(equip.get(i).isEtat()) switch1.setChecked(true);
					else switch1.setChecked(false);
					ll.addView(switch1); // Attache le Switch au layout parent
					switch1.setOnCheckedChangeListener(new OnCheckedChangeListener(){
						@Override
						public void onCheckedChanged(CompoundButton buttonView,
								boolean isChecked) {
							for(Equipement e : equip){
								if(e.getNom().equals(buttonView.getText())){
									System.out.println(e.getPin());
								}
							};
							
						}
					});//ajouter un listener
				}
		}

		return view;
	}
	private void chargementEquipements(final String nomPiece) {
		//Pour chaque equipement, créé une instance de Equipement et ajoute cette instance 
				//ˆ l'arrayList equip
		AccountManager account = new AccountManager();
		try {
			equip = account.getEquipement(nomPiece);
		} catch (JSONException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
			    
				/*if(nomPiece.equals("Salon")){
					Equipement tv = new Equipement("Télévision", true);
					equip.add(tv);
					Equipement lampe = new Equipement("Lampe", false);
					equip.add(lampe);
					Equipement ventilo = new Equipement("Ventilateur", true);
					equip.add(ventilo);
				}else if(nomPiece.equals("Garage")){
					Equipement lampe = new Equipement("Lampe", true);
					equip.add(lampe);
					Equipement ventilo = new Equipement("Porte", false);
					equip.add(ventilo);
				} else if(nomPiece.equals("Toilettes")){
					Equipement lampe = new Equipement("Lampe", true);
					equip.add(lampe);
				} else {
					Equipement lampe = new Equipement("Lampe principale", true);
					equip.add(lampe);
					Equipement ventilo = new Equipement("Lampe Secondaire", true);
					equip.add(ventilo);
				}*/
				
			}
}