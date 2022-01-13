package com.efficom.quizz;

class ReponseMultiple extends Reponse
{
    ReponseMultiple(String reponse, boolean ifgood){
        super(reponse, ifgood);
    }
    
    public void showReponse(){
        System.out.println("\nLes bonnes réponses sont : "+reponse);
    }
    
}