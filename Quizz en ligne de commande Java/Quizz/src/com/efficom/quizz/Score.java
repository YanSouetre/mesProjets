package com.efficom.quizz;

public class Score {

    int score;
    int scoMax;

    Score(int initScore, int initScoMax){
        this.score = initScore;
        this.scoMax = initScoMax;
    }

    public void addScore(){
        this.score += 1;
    }

    public void showScore(){
        if(score<(scoMax/2)) {
            System.out.println("\nVotre score est de "+score+"/"+scoMax);
        } else {
            System.out.println("\nBravo !\nVotre score est de "+score+"/"+scoMax);
        }
    }

}
