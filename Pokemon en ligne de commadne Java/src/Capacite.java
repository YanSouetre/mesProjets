import java.util.*;

public class Capacite {

    public String nom;
    public int puissance;
    public int preci;
    public int id;


    public Capacite(int id,String nom, int puissance, int preci){
        this.id = id;
        this.nom = nom;
        this.puissance = puissance;
        this.preci = preci;
    }


    public void show_Capa(){
        System.out.println("|"+id+"|"+this.nom+" -- pui."+puissance+" -- preci."+preci);
    }

    public int random(){
        return ((int) (Math.random() * ((100) + 1)));
    }

    public int random_capa(){
        return ((int) ( Math.random() * 2 + 1));
    }

}
