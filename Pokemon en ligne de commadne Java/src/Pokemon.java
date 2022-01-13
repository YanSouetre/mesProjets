import java.util.*;

public class Pokemon {

    public String nom;
    public int pv;
    public Capacite[] capa;
    public int id;


    public Pokemon(int id,String nom,int pv,Capacite[] capa){
        this.id = id;
        this.nom = nom;
        this.pv = pv;
        this.capa = capa;

    }


    public void show_Poke(){
        System.out.println(this.nom+" "+this.pv+"pv");
    }

    public void capacite(){
        for (Capacite key:capa) {
            key.show_Capa();
        }
    }


}
