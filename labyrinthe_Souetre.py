import random
import time

"""
La fonction generate prend en parametre la longueur du labyrinthe (b)
et créer un dictionnaire (dico) avec les cordonnées (i, j) de chaque formes (▲ = hero, 0 = eau, ▓ = mur, ■ = bordure)
"""
def generate(b): # Fonction générer une map
    dico = {} # créer un dictionnaire
    for i in range(b):
        for j in range(b):
            if(i== b-1 and j == b-1): dico[(i,j)] = "EXIT"# créer une Exit dans le dico             
            elif(i == 0 or j == 0 or i == b-1 or j == b-1): dico[(i,j)] = "■"  # créer les bords dans le dico          
            elif(i == 1 and j == 1): dico[(i,j)] = "▲" # créer le héro dans le dico             
            elif(random.randint(1, 6)==1):  dico[(i,j)] = "0"# créer l'eau dans le dico              
            elif(random.randint(1, 6)==1): dico[(i,j)] = "▓"# créer les murs dans le dico          
            else: dico[(i,j)] = " "# créer les espaces vides
    
    afficher(b, dico)
    time.sleep(0.3)
    deplacer(b, dico)  
    
"""
La fonction afficher permet d'afficher le labyrinthe grâce au dictionnaire 
"""
def afficher(b,dico): # Fonction pour afficher la map
    for i in range(b):
        for j in range(b):
            if(dico[(i,j)] == "■"):  print("■",end=" ")# Affiche les bords             
            elif(dico[(i,j)] == "EXIT"): print("EXIT",end=" ")# Affiche les Exit              
            elif(dico[(i,j)] == "▲"): print("▲",end=" ")# Affiche le Héro               
            elif(dico[(i,j)] == "0"): print("0",end=" ")# Affiche l'eau               
            elif(dico[(i,j)] == "▓"): print("▓",end=" ")# Affiche les murs              
            else: print(" ",end=" ")# Affiche les espaces vides
        print("")
             
"""
La fonction deplacer permet de deplacer le hero dans 5 directions (haut-droite, droite, bas-droite, bas, bas-gauche)
en allant de preference sur les sans obstacles puis celles avec un mur et en dernier celles avec de l'eau
"""

def deplacer(b,dico):
    boucle = True
    point = 0
    while(boucle == True):
        for i in range(b):
            for j in range(b):
                if (dico[(i,j)] > dico[(0,0)]):
                    if(dico[(i,j)]=="▲"):
                        if(dico[(b-2,b-2)] == "▲"): # condition de fin de programme
                            dico[(i+1,j+1)] = dico[(i,j)]
                            dico[(i,j)] = " "
                            afficher(b, dico)
                            print("Il y est ARRIVE, Bien ouèj !")
                            print("Votre score est de : ",point)
                            boucle = False
                            return
                        
                        elif(dico[(b-3,b-2)] == "▲"): # condition de debug avant fin de partie
                            if(dico[(b-2,b-2)] == " "): point+=1
                            elif(dico[(b-2,b-2)]== "▓"): point+=5
                            elif(dico[(b-2,b-2)]== "0"): point +=10
                            dico[(b-2,b-2)] = dico[(i,j)]
                        elif(dico[(b-2,b-3)] == "▲"): # condition de debug avant fin de partie
                            if(dico[(b-2,b-2)] == " "): point+=1
                            elif(dico[(b-2,b-2)]== "▓"): point+=5
                            elif(dico[(b-2,b-2)]== "0"): point +=10
                            dico[(b-2,b-2)] = dico[(i,j)]
                            
                        elif(dico[(i+1,j+1)] == " "): # Deplacement Bas-Droite si aucun obstacle
                            dico[(i+1,j+1)] = dico[(i,j)]
                            point += 1
                        elif(dico[(i,j+1)] == " "): # Deplacement Droite si aucun obstacle
                            dico[(i,j+1)] = dico[(i,j)]
                            point += 1
                        elif(dico[(i+1,j)] == " "):# Deplacement Bas si aucun obstacle
                            dico[(i+1,j)] = dico[(i,j)]
                            point += 1
                        elif(dico[(i+1,j-1)] == " "): # Deplacement Bas-Gauche si aucun obstacle
                            dico[(i+1,j-1)] = dico[(i,j)]
                            point += 1
                        elif(dico[(i-1,j+1)] == " "): # Deplacement Haut-Droite si aucun obstacle
                            dico[(i-1,j+1)] = dico[(i,j)]
                            point += 1
                            
                        elif(dico[(i+1,j+1)] == "▓"): # Deplacement Bas-Droite a travers un mur si encerclé par des murs
                            dico[(i+1,j+1)] = dico[(i,j)]
                            point += 5
                        elif(dico[(i,j+1)] == "▓"): # Deplacement Droite a travers un mur si encerclé par des murs
                            dico[(i,j+1)] = dico[(i,j)]
                            point += 5
                        elif(dico[(i+1,j)] == "▓"):  # Deplacement Bas a travers un mur si encerclé par des murs
                            dico[(i+1,j)] = dico[(i,j)]
                            point += 5
                        elif(dico[(i+1,j-1)] == "▓"):# Deplacement Bas-Gauche a travers un mur si encerclé par des murs
                            dico[(i+1,j-1)] = dico[(i,j)]
                            point += 5
                        elif(dico[(i-1,j+1)] == "▓"): # Deplacement Haut-Droite a travers un mur si encerclé par des murs
                            dico[(i-1,j+1)] = dico[(i,j)]
                            point += 5
                                   
                        elif(dico[(i+1,j+1)] == "0"): # Deplacement Bas-Droite a travers l'eau si encerclé par de l'eau
                            dico[(i+1,j+1)] = dico[(i,j)]
                            point += 10
                        elif(dico[(i,j+1)] == "0"): # Deplacement Droite a travers l'eau si encerclé par de l'eau
                            dico[(i,j+1)] = dico[(i,j)]
                            point += 10
                        elif(dico[(i+1,j)] == "0"): # Deplacement Bas a travers l'eau si encerclé par de l'eau
                            dico[(i+1,j)] = dico[(i,j)]
                            point += 10
                        elif(dico[(i+1,j-1)] == "0"): # Deplacement Bas-Gauche a travers l'eau si encerclé par de l'eau
                            dico[(i+1,j-1)] = dico[(i,j)]
                            point += 10
                        elif(dico[(i-1,j+1)] == "0"): # Deplacement Haut-Droite a travers l'eau si encerclé par de l'eau
                            dico[(i-1,j+1)] = dico[(i,j)]
                            point += 10
                        dico[(i,j)] = " "  
                    afficher(b, dico)
                    print("Votre score est de : ",point)
                    time.sleep(0.3)
                        
    
    
generate(20)