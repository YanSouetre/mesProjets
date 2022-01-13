package com.efficom.quizz;

import com.efficom.exception.NomDepasseException;
import com.efficom.exception.ReponseInexistanteException;
import com.efficom.exception.ReponseSaisieException;

import java.util.*;
public class Main
{

    public static void main(String[] args) {
        try {
            Scanner nom = new Scanner(System.in);
            System.out.println("Entrez votre nom : ");
            String n1 = nom.nextLine();
            Quizz quizz = new Quizz(n1);
            quizz.startQuizz();
        }
        catch (ReponseInexistanteException error1){
            System.out.println("Réponse Inexistante");
        }
        catch (ReponseSaisieException error2){
            System.out.println("Réponse saisie invalide");
        }
        catch (NomDepasseException error3) {
            System.out.println("Votre nom est trop long");
        }


    }
}