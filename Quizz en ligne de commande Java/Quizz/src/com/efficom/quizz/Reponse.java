package com.efficom.quizz;

import java.util.*;
public class Reponse
{
    public String reponse; 
    public boolean ifgood; 

    Reponse(String reponse, boolean ifgood){
        this.reponse = reponse;
        this.ifgood = ifgood;
    }

    public Reponse() {
    }

    public void showReponse(){
        System.out.println("\nLa bonne réponse est : "+reponse);
    }
    
    
}