package ephec.domhouse;

public class Equipement {
	private String nom;
	private boolean etat;
	
	public Equipement(String nom, boolean etat){
		this.nom = nom;
		this.etat = etat;
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
	public String toString(){
		return nom;
	}
}
