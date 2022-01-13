package com.efficom.quizz;

import com.efficom.exception.NomDepasseException;
import com.efficom.exception.ReponseInexistanteException;
import com.efficom.exception.ReponseSaisieException;

import java.util.*;
public class Quizz {

    public String nom;
    public ArrayList<Question> questions = new ArrayList<Question>();
    public Iterator<Question> iterateur;
    int nb_q = 0;
    Score sc = new Score(0, 5);


    Quizz(String nom) {
        this.nom = nom;
        initQuestionRep();
    }

    public void startQuizz() throws ReponseInexistanteException, ReponseSaisieException, NomDepasseException {
        if (this.nom.length() >= 20) throw new NomDepasseException();
        System.out.println("********************************************************");
        System.out.println("Bonjour "+ this.nom +" le quiz commence pour vous !!!");
        System.out.println("********************************************************\n");

        while(iterateur.hasNext()) {
            try{
                nb_q++;
                System.out.println("------------------------ com.efficom.quizz.Question " + nb_q + " ------------------------");
                iterateur.next().setReponse(this.sc);
            } catch(Exception error) {
                System.out.println("Erreur "+error+"\nLe programme continue tout de même");
            }
        }
        sc.showScore();
    }


    public void initQuestionRep(){
        questions.add(new Question("Est-ce que Lucas est nul sur CR ?\na) Oui\nb) Non", new Reponse[]{new Reponse("a",false),new Reponse("b",true)}));
        questions.add(new Question("Morike est dans le groupe ?\na) Oui\nb) Non\n", new Reponse[]{new Reponse("a",false),new Reponse("b",true)}));
        questions.add(new Question("Clash Royale est nul ?\na) Oui\nb) Non\n", new Reponse[]{new Reponse("a", true), new Reponse("b", false)}));
        questions.add(new Question("2 + 2 ?\na) 22\nb) 4\nc) 04", new Reponse[]{new Reponse("a",false),new ReponseMultiple("bc",true)}));
        questions.add(new Question("1 + 0 ?\na) 1\nb) 3\nc) 1\nd) 8", new Reponse[]{new Reponse("b",false),new Reponse("d",false),new ReponseMultiple("ac",true)}));
        iterateur = questions.iterator();
    }

}