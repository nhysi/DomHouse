package ephec.domhouse;

public class Equipement {
	private String nom;
	private boolean etat;
	private int pin;
	
	public Equipement(String nom, boolean etat,int pin){
		this.nom = nom;
		this.etat = etat;
		this.pin = pin;
	}

	public String getNom() {
		return nom;
	}

	public void setNom(String nom) {
		this.nom = nom;
	}

	public boolean isEtat() {
		return etat;
	}

	public void setEtat(boolean etat) {
		this.etat = etat;
	}
	public int getPin(){
		return this.pin;
	}
	public String toString(){
		return nom;
	}
}
