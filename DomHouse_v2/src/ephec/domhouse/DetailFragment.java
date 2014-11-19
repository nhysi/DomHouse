package ephec.domhouse;
import java.util.ArrayList;

import android.app.Fragment;
import android.content.Context;
import android.graphics.Color;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
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
        	
        	//ajouter un listener
        }
        
        return view;
    }
	private void chargementEquipements(String nomPiece) {
		//Pour chaque equipement, créé une instance de Equipement et ajoute cette instance 
		//ˆ l'arrayList equip
		if(nomPiece.equals("Salon")){
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
		}
		
	}
}