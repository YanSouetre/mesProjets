# -*- coding: utf-8 -*-
"""
Created on Mon Dec 13 21:43:01 2021

@author: souet
"""
import random


def generate():
    dico = {}
    couleur2 = ""
    boucle = True
    while( boucle == True):
        print("Choisissez la couleur du joueur 1 (noir ou blanc) :")
        rep = input()
        if(rep != "blanc" and rep != "noir"): print("reponse invalide !, recommencez")
        elif(rep == "blanc"): 
            rep = "●"
            couleur2 = "○"
            boucle = False
        elif(rep == "noir"): 
            rep = "○"
            couleur2 = "●"
            boucle = False
    start = random.randint(1, 2)
    print("Joueur 1 : ",rep)
    print("Joueur 2 : ",couleur2)
    for i in range(10):
        for j in range(10):           
            if((i+1)%2==0):
                if(i<=3):
                    if((j+1)%2==1): 
                        if(rep == "○"): dico[(chr(i+97),j+1)] = "●"
                        elif(rep == "●"): dico[(chr(i+97),j+1)] = "○"
                    else: dico[(chr(i+97),j+1)] = " "
                elif(i>=6):
                    if((j+1)%2==1): 
                        if(rep == "○"): dico[(chr(i+97),j+1)] = "○"
                        elif(rep == "●"): dico[(chr(i+97),j+1)] = "●"
                    else: dico[(chr(i+97),j+1)] = " "
                else: dico[(chr(i+97),j+1)] = " "
            elif((i+1)%2==1):
                if(i<=3):
                    if((j+1)%2==0):
                        if(rep == "○"): dico[(chr(i+97),j+1)] = "●"
                        elif(rep == "●"): dico[(chr(i+97),j+1)] = "○"
                    else: dico[(chr(i+97),j+1)] = " "
                elif(i>=6):
                    if((j+1)%2==0):
                        if(rep == "○"): dico[(chr(i+97),j+1)] = "○"
                        elif(rep == "●"): dico[(chr(i+97),j+1)] = "●"
                    else: dico[(chr(i+97),j+1)] = " "
                else: dico[(chr(i+97),j+1)] = " "
            """if(i+1 == 6 and j+1== 5):
                if(rep == "○"): dico[(chr(i+97),j+1)] = "○"
                elif(rep == "●"): dico[(chr(i+97),j+1)] = "●"
                """
    afficher(dico)
    dame(rep, couleur2, dico, start)
     


          

def afficher(dico):
    print("  "+"\033[4m"+ "1 2 3 4 5 6 7 8 9 10"+"\033[0m")
    for i in range(10):
        print(chr(i+97),end="|")
        for j in range(10):
            if(dico[(chr(i+97),j+1)] == "●"): print("\033[4m"+"●"+"\033[0m", end="|")
            elif(dico[(chr(i+97),j+1)] == "○"): print("\033[4m"+"○"+"\033[0m", end="|")
            elif(dico[(chr(i+97),j+1)] == " "): print("\033[4m"+" "+"\033[0m", end="|")
        print("")
    print("  1 2 3 4 5 6 7 8 9 10")
    



def dame(couleur, couleur2, dico, start):
    couleur_act = ""
    game_over = False
    cou_jou = False
    while(game_over==False):  
        erreur = False
        while(erreur == False):
            if (start == 1): 
                print("Au tour du Joueur 1")
                couleur_act = couleur
            else: 
                print("Au tour du Joueur 2")
                couleur_act = couleur2
            tab = voisin(couleur_act, dico)
            if(len(tab[1]) > 0):
                verif = False
                pions = []
                for l in range(len(tab[0])):
                    if(dico[(chr(tab[0][l][0]),tab[0][l][1])] == couleur_act):
                        cou_jou = True
                    pions += [(chr(tab[0][l][0]),tab[0][l][1])]
                boucle2 = True
                while(boucle2 == True):   
                    if(cou_jou == True):
                        print("Vous pouvez manger un pions ennemi ! avec le(s) pion(s) :",pions)
                        print("Quel pion voulez vous choisir ?")
                        rep = input().split(" ")
                        rep[0] = ord(rep[0])
                        rep[1] = int(rep[1])
                        for k in range(len(tab[0])):
                            if(rep[0] == tab[0][k][0] and rep[1] == tab[0][k][1]):
                                verif = True
                        if(verif == True):
                            tab = voisin(couleur_act, dico)
                            manger(couleur_act, dico, tab[0], tab[1], rep[0], rep[1])
                            afficher(dico)
                            if(start == 1): start = 2
                            else: start = 1
                            boucle2 = False
                        else:
                            print("Ce pion n'est pas valide !")
                    else: 
                        erreur = True 
                        boucle2 = False
            else:
                print("Quel pion voulez vous bouger ? (ex:g 2)")
                rep = input().split(" ")
                rep[0] = ord(rep[0])
                rep[1] = int(rep[1])
            if(len(rep) == 1):
                print("Erreur : veuillez mettre un espace entre la lettre et le chiffre (ex:g 2)")
            elif(len(rep) > 2):
                print("Erreur : il ne doit y avoir seulement une lettre et un chiffre (ex:g 10)")
            elif(chr(rep[0]) < "a" or chr(rep[0]) > "j"):
                print("Erreur : la lettre doit être comprise entre a et j et non majuscule")
            elif(int(rep[1]) < 1 or int(rep[1]) > 10):
                print("Erreur : le chiffre est compris entre 1 et 10")
            else:
                erreur = True

            for i in range(97,107):
                for j in range(1,11): 
                    if(i == rep[0] and j == rep[1]): 
                        if(start == 1): #TOUR JOUEUR 1
                            couleur_act = couleur
                            if(dico[(chr(i),j)] == couleur_act):
                                depla = deplacement(couleur_act, dico, i, j, start)
                                afficher(dico)
                                if(depla != False):
                                    start = 2
                            elif(dico[(chr(i),j)] != couleur_act and dico[(chr(i),j)] != " "):
                                print("Ce pion n'est pas a vous !")
                            elif(dico[(chr(i),j)] == " "):
                                print("Il n'y a aucun pion ici !")
                        elif(start == 2): #TOUR JOUEUR 2
                            couleur_act = couleur2
                            if(dico[(chr(i),j)] == couleur_act):
                                depla = deplacement(couleur_act, dico, i, j, start)
                                afficher(dico)
                                if(depla != False):
                                    start = 1
                            elif(dico[(chr(i),j)] != couleur_act and dico[(chr(i),j)] != " "):
                                print("Ce pion n'est pas a vous !")
                            elif(dico[(chr(i),j)] == " "):
                                print("Il n'y a aucun pion ici !")
                

def manger(couleur, dico, tab , tab1, rep0 , rep1):
    h_gauche = False
    h_droite = False
    b_gauche = False
    b_droite = False
    bouffe = True
    while(bouffe == True):
        for i in range(97,107):
            for j in range(1,11):
                if(rep0 == i and rep1 == j):
                    if(i > 98 and j > 2):
                        if(dico[(chr(i-2),j-2)] == " " and dico[(chr(i-1),j-1)] != couleur and dico[(chr(i-1),j-1)] != " "): #HAUT-GAUCHE VERIF ALLY
                            h_gauche = True
                    if(i > 98 and j < 9):
                        if(dico[(chr(i-2),j+2)] == " " and dico[(chr(i-1),j+1)] != couleur and dico[(chr(i-1),j+1)] != " "): #HAUT-DROITE VERIF ALLY
                            h_droite = True
                    if(i < 105 and j < 9):
                        if(dico[(chr(i+2),j+2)] == " " and dico[(chr(i+1),j+1)] != couleur and dico[(chr(i+1),j+1)] != " "): #BAS-DROITE VERIF ALLY
                            b_droite = True
                    if(i < 105 and j > 2):
                        if(dico[(chr(i+2),j-2)] == " " and dico[(chr(i+1),j-1)] != couleur and dico[(chr(i+1),j-1)] != " "): #BAS-GAUCHE VERIF ALLY
                            b_gauche = True
           
                    if(h_droite == False and h_gauche == True and b_droite == False and b_gauche == False):
                        dico[(chr(i-2),j-2)] = dico[(chr(i),j)]
                        dico[(chr(i),j)], dico[(chr(i-1),j-1)] = " ", " "
                        print("Le pion a été déplacé en haut à gauche")
                        rep0 = rep0-2
                        rep1 = rep1-2
                    elif(h_droite == True and h_gauche == False and b_droite == False and b_gauche == False):    
                        dico[(chr(i-2),j+2)] = dico[(chr(i),j)]
                        dico[(chr(i),j)], dico[(chr(i-1),j+1)] = " ", " "
                        print("Le pion a été déplacé en haut à droite")
                        rep0 = rep0-2
                        rep1 = rep1+2
                    elif(h_droite == False and h_gauche == False and b_droite == False and b_gauche == True):
                        dico[(chr(i+2),j-2)] = dico[(chr(i),j)]
                        dico[(chr(i),j)], dico[(chr(i+1),j-1)] = " ", " "
                        print("Le pion a été déplacé en bas à gauche")
                        rep0 = rep0+2
                        rep1 = rep1-2
                    elif(h_droite == False and h_gauche == False and b_droite == True and b_gauche == False):
                        dico[(chr(i+2),j+2)] = dico[(chr(i),j)]
                        dico[(chr(i),j)], dico[(chr(i+1),j+1)] = " ", " "
                        print("Le pion a été déplacé en bas à droite")
                        rep0 = rep0+2
                        rep1 = rep1+2
                    else:
                        boucle = True
                        while(boucle == True):
                           print("Où déplacer le pions ? (ex: haut gauche / bas droite)")
                           rep = input()
                           if(rep == "haut droite" and h_droite == True):
                               dico[(chr(i-2),j+2)] = dico[(chr(i),j)]
                               dico[(chr(i),j)], dico[(chr(i-1),j+1)] = " ", " "
                               print("Le pion a été déplacé en haut à droite")
                               boucle = False
                               rep0 = rep0-2
                               rep1 = rep1+2
                           elif(rep == "haut gauche" and h_gauche == True):
                               dico[(chr(i-2),j-2)] = dico[(chr(i),j)]
                               dico[(chr(i),j)], dico[(chr(i-1),j-1)] = " ", " "
                               print("Le pion a été déplacé en haut à gauche")
                               boucle = False
                               rep0 = rep0-2
                               rep1 = rep1-2
                           elif(rep == "bas droite" and b_droite == True):
                               dico[(chr(i+2),j+2)] = dico[(chr(i),j)]
                               dico[(chr(i),j)], dico[(chr(i+1),j+1)] = " ", " "
                               print("Le pion a été déplacé en bas à droite")
                               boucle = False
                               rep0 = rep0+2
                               rep1 = rep1+2
                           elif(rep == "bas gauche" and b_gauche == True):
                               dico[(chr(i+2),j-2)] = dico[(chr(i),j)]
                               dico[(chr(i),j)], dico[(chr(i+1),j-1)] = " ", " "
                               print("Le pion a été déplacé en bas à gauche")
                               boucle = False
                               rep0 = rep0+2
                               rep1 = rep1-2
                           elif(rep != "haut droite" and rep != "haut gauche" and rep != "bas gauche" and rep != "bas droite"):
                               print("reponse invalide")
                           else:
                               print("Action impossible !")




def deplacement(couleur, dico, i, j, start):
    gauche = False
    droite = False
    tab = voisin(couleur, dico)
    if(start == 1):
        if(i > 97 and j > 1):
            if(dico[(chr(i-1),j-1)] == " "): #HAUT-GAUCHE VERIF ALLY
                gauche = True
        if(i > 97 and j < 10):
            if(dico[(chr(i-1),j+1)] == " "): #HAUT-DROITE VERIF ALLY
                droite = True
    elif(start == 2):
        if(i < 106 and j < 10):
            if(dico[(chr(i+1),j+1)] == " "): #BAS-DROITE VERIF ALLY
                droite = True
        if(i < 106 and j > 1):
            if(dico[(chr(i+1),j-1)] == " "): #BAS-GAUCHE VERIF ALLY
                gauche = True
    if(droite == False and gauche == False):
        print("Deplacement impossible pour ce pion")
        return False
    if(len(tab[1] ) == 0):
        if(droite == False and gauche == True and start == 1):
            dico[(chr(i-1),j-1)] = dico[(chr(i),j)]
            dico[(chr(i),j)] = " "
            print("Le pion a été déplacé à gauche")
        elif(droite == True and gauche == False and start == 1):
            dico[(chr(i-1),j+1)] = dico[(chr(i),j)]
            dico[(chr(i),j)] = " "
            print("Le pion a été déplacé à droite")
        elif(droite == False and gauche == True and start == 2):
            dico[(chr(i+1),j-1)] = dico[(chr(i),j)]
            dico[(chr(i),j)] = " "
            print("Le pion a été déplacé à gauche")
        elif(droite == True and gauche == False and start == 2):
            dico[(chr(i+1),j+1)] = dico[(chr(i),j)]
            dico[(chr(i),j)] = " "
            print("Le pion a été déplacé à droite")
        else:
            boucle = True
            while(boucle == True):
               print("Deplacer à droite ou gauche ?")
               rep = input()
               if(rep == "droite" and droite == True and start == 1):
                   dico[(chr(i-1),j+1)] = dico[(chr(i),j)]
                   dico[(chr(i),j)] = " "
                   boucle = False
               elif(rep == "gauche" and gauche == True and start == 1):
                   dico[(chr(i-1),j-1)] = dico[(chr(i),j)]
                   dico[(chr(i),j)] = " "
                   boucle = False
               elif(rep == "droite" and droite == True and start == 2):
                   dico[(chr(i+1),j+1)] = dico[(chr(i),j)]
                   dico[(chr(i),j)] = " "
                   boucle = False
               elif(rep == "gauche" and gauche == True and start == 2):
                   dico[(chr(i+1),j-1)] = dico[(chr(i),j)]
                   dico[(chr(i),j)] = " "
                   boucle = False
               elif(rep != "droite" and rep != "gauche"):
                   print("reponse invalide")
    
       
               
               
                     
def voisin(couleur, dico):
    tab = []
    tab2 = []
    for i in range(97,107):
        for j in range(1,11):
            if(dico[(chr(i),j)] == couleur):     
                if(i > 97 and j > 1):
                    if(dico[(chr(i-1),j-1)] != couleur and dico[(chr(i-1),j-1)] != " "): #HAUT-GAUCHE 
                        if(i > 98 and j > 2): 
                            if(dico[(chr(i-2),j-2)] == " "): #2xHAUT-GAUCHE
                                tab += [(i,j)] 
                                tab2 += [(i-2,j-2)]
                if(i < 106 and j > 1):
                    if(dico[(chr(i+1),j-1)] != couleur and dico[(chr(i+1),j-1)] != " "): #BAS-GAUCHE                         
                        if(i < 105 and j > 2 ): 
                            if(dico[(chr(i+2),j-2)] == " "): #2xBAS-GAUCHE
                                tab += [(i,j)]
                                tab2 += [(i+2,j-2)]
                if(i < 106 and j < 10):
                    if(dico[(chr(i+1),j+1)] != couleur and dico[(chr(i+1),j+1)] != " "):  #BAS-DROITE                        
                        if(i < 105 and j < 9): 
                            if(dico[(chr(i+2),j+2)] == " "): #2xBAS-DROITE
                                tab += [(i,j)]
                                tab2 += [(i+2,j+2)]
                if(i > 97 and j < 10):
                    if(dico[(chr(i-1),j+1)] != couleur and dico[(chr(i-1),j+1)] != " "):  #HAUT-DROITE                       
                        if(i > 98 and j < 9): 
                            if(dico[(chr(i-2),j+2)] == " "): #2xHAUT-DROITE
                                tab += [(i,j)]
                                tab2 += [(i-2,j+2)]

                     
    return tab, tab2

    
