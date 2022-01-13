import java.util.*;

public class Combat {

    public ArrayList<Pokemon> poke = new ArrayList<>();
    Scanner chx = new Scanner(System.in);
    Scanner chx_adv = new Scanner(System.in);
    Scanner atq_al = new Scanner(System.in);
    Scanner atq_en = new Scanner(System.in);

    int rep;
    int rep2;
    int pv_en;
    int pv_al;
    int rand_capa;



    public Combat(){
        initPokemon();
    }

    public void launch_fight(){
        choix();
        fight();

    }


    public void initPokemon(){
        poke.add(new Pokemon(1,"tiplouf",55,new Capacite[]{
                new Capacite(1,"coupe",3,100),
                new Capacite(2,"bulle d'eau",7,75),
                new Capacite(3,"Surf",12,45)}));

        poke.add(new Pokemon(2,"hericendre",45,new Capacite[]{
                new Capacite(1,"coupe",4,100),
                new Capacite(2,"flammèche",9,75),
                new Capacite(3,"Lance flamme",15,45)}));

        poke.add(new Pokemon(3,"tortipouss",45,new Capacite[]{
                new Capacite(1,"coupe",4,100),
                new Capacite(2,"fouet liane",9,75),
                new Capacite(3,"noeud herbe",15,45)}));

    }


    public void choix(){
        System.out.println("Choisissez votre pokémon pour le combat : ");
        for (Pokemon key: poke) {
            System.out.println("--------------------|"+key.id+"|-----------------------");
            key.show_Poke();
            key.capacite();
            System.out.println("----------------------------------------------");
        }
        rep = chx.nextInt();
        if (rep > poke.size()){
            System.out.println("Erreur ce pokemon n'existe pas !");
        } else {
            for (Pokemon key: poke) {
                if (key.id == rep){
                    System.out.println("Le pokemon que vous avez choisi est : ");
                    System.out.println("--------------------|"+key.id+"|-----------------------");
                    key.show_Poke();
                    key.capacite();
                    System.out.println("----------------------------------------------");
                }
            }
        }
        System.out.println("Choisissez votre adversaire : ");
        rep2 = chx_adv.nextInt();
        if (rep2 > poke.size()){
            System.out.println("Erreur ce pokemon n'existe pas !");
        } else {
            for (Pokemon key: poke) {
                if (key.id == rep2){
                    System.out.println("Le pokemon adverse est : ");
                    System.out.println("--------------------|"+key.id+"|-----------------------");
                    key.show_Poke();
                    key.capacite();
                    System.out.println("----------------------------------------------");
                }
            }
        }
    }

    public void initPv(){
        for (Pokemon key: poke) { //KEY = POKEMON
            if (rep2 == key.id){
                pv_en = key.pv;
            }
            else if (rep == key.id){
                pv_al = key.pv;
            }
        }
    }


    public void barre_pv_ally(){
        for (Pokemon key: poke) {
            if (key.id == rep){
                System.out.print(key.nom+" ");
                for (int i = 0; i<pv_al;i++){
                    System.out.print("|");
                }
                System.out.print(" "+pv_al+"/"+ key.pv+"pv");
            }
        }
    }

    public void barre_pv_ennemy(){
        for (Pokemon key: poke) {
            if (key.id == rep2){
                System.out.print(key.nom+" ");
                for (int i = 0; i<pv_en;i++){
                    System.out.print("|");
                }
                System.out.print(" "+pv_en+"/"+ key.pv+"pv");
            }
        }
    }

    public void atq_ally(){
        System.out.println("\nSelectionner une capacité");
        for (Pokemon key: poke){//KEY1 = POKEMON
            if (rep == key.id){
                key.capacite();
                int damage = atq_al.nextInt();
                for (Capacite key2:key.capa) { //KEY2 = CAPA POKE ALLY
                    rand_capa = key2.random_capa();
                    if (damage == key2.id){
                        if (key2.preci >= key2.random()){
                            if (20 >= key2.random()){
                                pv_en = pv_en - (key2.puissance*2);
                                System.out.println("Coup critique");
                                System.out.println(key.nom+" attaque "+key2.nom+" -"+(key2.puissance*2)+"pv");
                            } else{
                                pv_en = pv_en - key2.puissance;
                                System.out.println(key.nom+" attaque "+key2.nom+" -"+key2.puissance+"pv");
                            }
                            barre_pv_ennemy();

                        }else{
                            System.out.println(key.nom+" attaque "+key2.nom);
                            System.out.println("L'attaque à échoué !");
                        }
                    }
                }
            }
        }
    }

    public void atq_ennemy(){
        System.out.println("\nAppuyer sur <ENTREE> pour continuer");
        String enter = atq_en.nextLine();
        if (Objects.equals(enter, "")){
            System.out.println("Attaque adverse : ");
            for (Pokemon key1: poke){ //KEY1 = POKEMON
                if (rep2 == key1.id){
                    for (Capacite key2:key1.capa) {
                        if (rand_capa == key2.id){
                            if (key2.preci >= key2.random()){
                                if (20 >= key2.random()){
                                    pv_al = pv_al - (key2.puissance*2);
                                    System.out.println("Coup critique");
                                    System.out.println(key1.nom+" attaque "+key2.nom+" -"+(key2.puissance*2)+"pv");
                                } else{
                                    pv_al = pv_al - key2.puissance;
                                    System.out.println(key1.nom+" attaque "+key2.nom+" -"+key2.puissance+"pv");
                                }
                                barre_pv_ally();

                            }else{
                                System.out.println(key1.nom+" attaque "+key2.nom);
                                System.out.println("L'attaque à échoué !");
                            }
                        }
                    }
                }
            }
        }
    }


    public void fight(){
        System.out.println("Que le combat COMMENCE !!!");
        initPv();
        while(pv_en > 0 || pv_al > 0){
            atq_ally();
            if (pv_en <= 0){
                System.out.println("Vous avez gagné !");
                break;
            }
            atq_ennemy();
            if (pv_al <= 0){
                System.out.println("Vous avez perdu !");
                break;
            }
        }
    }

}
