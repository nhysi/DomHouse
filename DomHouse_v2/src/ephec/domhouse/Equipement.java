package ephec.domhouse;

public class Equipement {
	private String nom;
	private boolean etat;
	private boolean modifiable;
	private int pin;
	
	public Equipement(String nom, boolean etat, int pin, boolean modifiable){
		this.nom = nom;
		this.etat = etat;
		this.modifiable = modifiable;
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
	public boolean isModifiable() {
		return modifiable;
	}
	public int getPin(){
		return pin;
	}

	public void setModifiable(boolean modifiable) {
		this.modifiable = modifiable;
	}
}
