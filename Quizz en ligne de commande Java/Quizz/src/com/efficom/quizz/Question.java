package com.efficom.quizz;

import com.efficom.exception.ReponseInexistanteException;
import com.efficom.exception.ReponseSaisieException;

import java.util.*;
public class Question
{


    public Reponse[] reponse;
    public String questionpose;
    Scanner rep = new Scanner(System.in);

    Question(String questionpose, Reponse[] reponse){
        this.questionpose = questionpose;
        this.reponse  = reponse;
    }

    public String[] quest_rep(){
        System.out.println(questionpose);
        System.out.println("entrez votre reponse : ");
        String reponse_donne = rep.nextLine();
        String[] reponseSplit = reponse_donne.split("");
        return  reponseSplit;
    }

    public void setReponse(Score sc) throws ReponseInexistanteException, ReponseSaisieException {
        String[] reponseSplit = this.quest_rep();

        ArrayList<String> bonneReponses = new ArrayList<String>();
        Reponse Reponse = null;
        for(Reponse key :reponse){
            if(key.ifgood) {
                Reponse = key;
                String[] plusieursReponses = key.reponse.split("");
                for(String key2: plusieursReponses) {
                    bonneReponses.add(key2);
                }
            }
        }

        if(bonneReponses.size() != reponseSplit.length) {
            this.sh_result(Reponse, false, sc);
            return;
        }
        for(int i = 0; i < reponseSplit.length; i++){
            boolean exist = false;
            if(reponseSplit[i].matches(".*[0-9].*")) throw new ReponseSaisieException();

            for (Reponse key:reponse) {
                String[] plusieursReponses = key.reponse.split("");
                for(String key2: plusieursReponses) {
                    if (reponseSplit[i].equals(key.reponse) || reponseSplit[i].equals(key2)) {
                        exist = true;
                        break;
                    }
                }
            }
            if (!exist) throw new ReponseInexistanteException();
        }

        boolean ifGagne = true;
        for(int i = 0; i < bonneReponses.size(); i++) {

            if (reponseSplit.length >= (i+1)) {
                if(ifGagne) {
                    if ((bonneReponses.get(i).equals(reponseSplit[i])) == false) {
                        ifGagne = false;
                    }
                }
            }
        }
        this.sh_result(Reponse, ifGagne, sc);
    }


    public void sh_result(Reponse Reponse, boolean ifGagne, Score sc){
        if(ifGagne) {
            System.out.println("Bonne reponse !!");
            sc.addScore();
        } else {
            System.out.print("Mauvaise reponse !!");
            Reponse.showReponse();
        }
    }


}