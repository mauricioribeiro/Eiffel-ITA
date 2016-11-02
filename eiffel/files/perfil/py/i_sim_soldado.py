import math

class i_sim_soldado:

    E = 20000 #Modulo de elasticidade 
    G = 7700  #Modulo de cisalhamento transversal

    def verificarTracao(self,Area,fy,gamma1,Ct,An,fu,gamma2,L,rx,ry,Anv,Ant,Agv,NtSd):
        EL1, EL2, EL3, EL4 = 'Esbeltez', 'Escoamento da Secao Bruta', 'Ruptura da Secao Liquida', 'Colapso por rasgamento'
        Sd1, Sd2, Sd3, Sd4 = L/min(rx,ry), NtSd, NtSd, NtSd
        Rd1, Rd2, Rd3, Rd4 = 0.0, 0.0, 0.0, 0.0
        OK1, OK2, OK3, OK4 = False, False, False, False

        Rd1 = 300 #NBR8800: Item 5.2.8.1
        #Estado-limite de Escoamento da Secao Bruta
        Rd2 = Area * fy / gamma1 # NBR8800: Item 5.2.2a
        #Estado-limite de Ruptura da Secao Liquida
        Rd3 = Ct * An * fu / gamma2 # NBR8800: Item 5.2.2b
        #Estado-limite de Colapso por Rasgamento
        Cts = 1
        Rd4 = min((0.6*fu*Anv+Cts*fu*Ant)/gamma2,(0.6*fy*Agv+Cts*fu*Ant)/gamma2) #NBR8800: Item 6.5.6
        
        #Verificacao do EL1
        if (Sd1 <= Rd1): 
            OK1 = True
        #Verificacao do EL2
        if (Sd2 <= Rd2): 
            OK2 = True
        #Verificacao do EL3
        if (Sd3 <= Rd3): 
            OK3 = True
        #Verificacao do EL4
        if (Sd4 <= Rd4): 
            OK4 = True
        #Margem de Segurança de EL1
        MS1 = round(100*(Rd1/Sd1-1),2)
        #Margem de Segurança de EL2
        MS2 = round(100*(Rd2/Sd2-1),2)
        #Margem de Segurança de EL3
        MS3 = round(100*(Rd3/Sd3-1),2)
        #Margem de Segurança de EL4
        MS4 = round(100*(Rd4/Sd4-1),2)
 
        return [
            [EL1, Sd1, Rd1, MS1, OK1,False],
            [EL2, Sd2, Rd2, MS2, OK2,True],
            [EL3, Sd3, Rd3, MS3, OK3,True],
            [EL4, Sd4, Rd4, MS4, OK4,True]
        ]


    def verificarCompressao(self,Area,Kx,Ky,Kz,Lx,Ly,Lz,fy,d,bf,tf,tw,h,hw,Ix,Iy,Cw,J,gamma1,NcSd):
        EL1, EL2 = 'Esbeltez', 'Flambagem'
        Sd1,Sd2 = max( [Kx*Lx/math.sqrt(Ix/Area),Ky*Ly/math.sqrt(Iy/Area)]),NcSd
        Rd1,Rd2 = 0.0, 0.0
        OK1,OK2 = False, False

        #Transformacao de unidade de mm para cm
        d=d/10
        bf=bf/10
        tf=tf/10
        tw=tw/10
        h=h/10
        hw=hw/10

        Rd1 = 200 #NBR8800: Item 5.3.4.1
        
        #Calculo de Ne
        r0 = math.sqrt(Ix/Area + Iy/Area)
        Nex = (math.pi)**2*(self.E)*Ix/(Kx*Lx)**2 #NBR8800: Item E.1.1a
        Ney = (math.pi)**2*(self.E)*Iy/(Ky*Ly)**2 #NBR8800: Item E.1.1b
        Nez = (1/r0**2)*((math.pi)**2*(self.E)*Cw/(Kz*Lz)**2+(self.G)*J) #NBR8800: Item E.1.1c
        Ne = min ([Nex,Ney,Nez])
        Qs=0
        Qa=0
        
        #Calculo de Qs
        kc = 4/math.sqrt(h/tw) #NBR8800: Item F.2c
        if (kc < 0.35 or kc > 0.76):
            if(kc < 0.35):
                kc=0.35
            else:
                kc=0.76
        if (bf/(2*tf) <= 0.64*math.sqrt((self.E)*kc/fy)): #NBR8800: Tabela F.1, Elementos AL, Grupo 5
            Qs = 1
        else:
            if (bf/(2*tf) <= 1.17*math.sqrt((self.E)*kc/fy)): #NBR8800: Item F.2c
                Qs = 1.415-0.65*bf/(2*tf)*math.sqrt(fy/(kc*(self.E))) #NBR8800: Item F.2c
            else:
                Qs = 0.9*(self.E)*kc/(fy*(bf/(2*tf))**2) #NBR8800: Item F.2c
                
        #Calculo de Qa
        if (h/tw <= 1.49*math.sqrt((self.E)/fy)): #NBR8800: Tabela F.1,Elementos AA, Grupo 2
            Qa = 1
        else:
            bef = 1.92*tw*math.sqrt((self.E)/fy)*(1-0.34*tw/h*math.sqrt((self.E)/fy)) #NBR8800: Item F.3.2
            if (bef >= h):
                bef=h;
            else:
                Aef = Area-(h-bef)*tw #NBR8800: Item F.3.1
                Qa = Aef/Area #NBR8800: Item F.3.1
                
        #Calculo de Q
        Q = Qs * Qa #NBR8800: Item F.1
        
        #Calculo de Lambda0
        Lambda0 = math.sqrt(Q*Area*fy/Ne) #NBR8800: Item 5.3.3.2
        
        #Calculo de Qui
        if(Lambda0 <= 1.5):
            Qui = 0.658**((Lambda0)**2) #NBR8800: Item 5.3.3.1
        else:
            Qui = 0.877/(Lambda0)**2 #NBR8800: Item 5.3.3.1
            
        #Calculo da forca axial resistente de compressao
        Rd2 = Qui*Q*Area*fy/gamma1 #NBR8800: Item 5.3.3.2
        
        #Verificacao do EL1
        if (Sd1 <= Rd1): 
            OK1 = True
        #Verificacao do EL2
        if (Sd2 <= Rd2): 
            OK2 = True
        #Margem de Segurança de EL1
        MS1 = round(100*(Rd1/Sd1-1),2)
        #Margem de Segurança de EL2
        MS2 = round(100*(Rd2/Sd2-1),2)
        
        return [
            [EL1, Sd1, Rd1, MS1, OK1,False],
            [EL2, Sd2, Rd2, MS2, OK2,True],
        ]



    def verificarFletorX(self,Cb,fy,fu,d,bf,tf,tw,h,hw,Lb,ry,Zx,gamma1,Iy,J,Cw,Wx,a,Afn,MSd):

        #Transformacao de unidade de mm para cm
        d=d/10
        bf=bf/10
        tf=tf/10
        tw=tw/10
        h=h/10
        hw=hw/10
        
        L=Lb
        Lambda = h/tw #NBR8800: Tabela G.1, Estado-limite FLA
        #Verificacao da esbeltez
        if Lambda <= 5.7*math.sqrt((self.E)/fy): #NBR8800: Tabela G.1, Estado-limite FLA
            #Viga de alma nao-esbelta: Anexo G
            
            EL1, EL2, EL3, EL4, EL5 = 'Flambagem Lateral com Torcao', 'Flambagem Local da Mesa', 'Flambagem Local da Alma', 'Analise Elastica', 'Ruptura da Mesa Tracionada'
            Sd1, Sd2, Sd3, Sd4, Sd5 = MSd, MSd, MSd, MSd, MSd
            Rd1, Rd2, Rd3, Rd4, Rd5 = 0.0, 0.0, 0.0, 1.5*Wx*fy/gamma1, 0.0
            OK1, OK2, OK3, OK4, OK5 = False, False, False, False, False
            
            #Estado-limite FLT (Flambagem Lateral com Torcao)
            if( L==0):
                Rd1 = 'N/A'
                OK1 = True
            else:
                LambdaFLT = L/ry #NBR8800: Tabela G.1
                LambdapFLT = 1.76*math.sqrt((self.E)/fy) #NBR8800: Tabela G.1
                beta1 = 0.7*fy*Wx/((self.E)*J)
                LambdarFLT = 1.38*math.sqrt(Iy*J)/(ry*J*beta1)*math.sqrt(1+math.sqrt(1+27*Cw*beta1**2/Iy)) #NBR8800: Tabela G.1
                MplFLT = Zx*fy
                MrFLT = 0.7*fy*Wx
                McrFLT = (Cb*(math.pi)**2*(self.E)*Iy/(L**2)*math.sqrt(Cw/Iy*(1+0.039*J*L**2/Cw)))
                if ( LambdaFLT <= LambdapFLT):
                    Rd1 = MplFLT/gamma1 #NBR8800: Item G.2.1a
                else:           
                    if(LambdaFLT <= LambdarFLT):
                        Rd1 = Cb/(gamma1)*(MplFLT-(MplFLT-MrFLT)*(LambdaFLT-LambdapFLT)/(LambdarFLT-LambdapFLT)) #NBR8800: Item G.2.1b
                    else:
                        Rd1 = McrFLT/gamma1 #NBR8800: Item G.2.1c
                
            #Estado-limite FLM (Flambagem Local da Mesa)
            LambdaFLM = bf/(2*tf) #NBR8800: Tabela G.1
            LambdapFLM = 0.38*math.sqrt((self.E)/fy) #NBR8800: Tabela G.1
            kc = 4/math.sqrt(h/tw) #NBR8800: Item F.2c
            if (kc < 0.35 or kc > 0.76):
                if(kc < 0.35):
                    kc=0.35
                else:
                    kc=0.76
            LambdarFLM = 0.95*math.sqrt((self.E)*kc/(0.7*fy)) #NBR8800: Tabela G.1
            MplFLM = Zx*fy
            MrFLM = 0.7*fy*Wx
            McrFLM = 0.9*(self.E)*kc*Wx/LambdaFLM**2
            if (LambdaFLM <= LambdapFLM):
                Rd2 = MplFLM/gamma1 #NBR8800: Item G.2.2a
            else:
                if (LambdaFLM <= LambdarFLM):
                    Rd2 = (MplFLM-(MplFLM-MrFLM)*(LambdaFLM-LambdapFLM)/(LambdarFLM-LambdapFLM))/gamma1 #NBR8800: Item G.2.2b
                else:
                    Rd2 = McrFLM/gamma1 #NBR8800: Item G.2.2c
            
            #Estado-limite FLA (Flambagem Local da Alma)
            LambdaFLA = h/tw #NBR8800: Tabela G.1
            LambdapFLA = 3.76*math.sqrt((self.E)/fy) #NBR8800: Tabela G.1
            LambdarFLA = 5.7*math.sqrt((self.E)/fy) #NBR8800: Tabela G.1
            MplFLA = Zx*fy
            MrFLA = fy*Wx
            if (LambdaFLA <= LambdapFLA):
                Rd3 = MplFLA/gamma1 #NBR8800: Item G.2.2a
            else:
                if(LambdaFLA <= LambdarFLA):
                    Rd3 = (MplFLA-(MplFLA-MrFLA)*(LambdaFLA-LambdapFLA)/(LambdarFLA-LambdapFLA))/gamma1 #NBR8800: Item G.2.2b
                else:
                    Rd3 = 'N/A' #NBR8800: Item G.2.2c
                    OK3 = True

            #Estado-limite Ruptura da Mesa Tracionada
            if (fy/fu <= 0.8):
                Yt = 1
            else:
                Yt = 1.1
            if (fu*Afn < Yt*fy*bf*tf):
                Rd5 = fu*Afn*Wx/(gamma1*bf*tf)
            else:
                Rd5 = 'N/A'
                OK5 = True
           
            #Verificacao do EL1
            if (Rd1 is not 'N/A' and Sd1 <= Rd1): 
                OK1 = True
            #Verificacao do EL2
            if (Sd2 <= Rd2): 
                OK2 = True
            #Verificacao do EL3
            if (Rd3 is not 'N/A' and Sd3 <= Rd3): 
                OK3 = True   
            #Verificacao do EL4
            if (Sd4 <= Rd4): 
                OK4 = True
            #Verificacao do EL5
            if (Rd5 is not 'N/A' and Sd5 <= Rd5): 
                OK5 = True
            #Margem de Segurança de EL1
            if (Rd1 is not 'N/A'):
                MS1 = round(100*(Rd1/Sd1-1),2)
            else:
                MS1 = 'N/A'
            #Margem de Segurança de EL2
            MS2 = round(100*(Rd2/Sd2-1),2)
            #Margem de Segurança de EL3
            if (Rd3 is not 'N/A'):
                MS3 = round(100*(Rd3/Sd3-1),2)
            else:
                MS3 = 'N/A'
            #Margem de Segurança de EL4
            MS4 = round(100*(Rd4/Sd4-1),2)
            #Margem de Segurança de EL5
            if (Rd5 is not 'N/A'):
                MS5 = round(100*(Rd5/Sd5-1),2)
            else:
                MS5 = 'N/A'
                
            return [
            [EL1, Sd1, Rd1, MS1, OK1,True],
            [EL2, Sd2, Rd2, MS2, OK2,True],
            [EL3, Sd3, Rd3, MS3, OK3,True],
            [EL4, Sd4, Rd4, MS4, OK4,True],
            [EL5, Sd5, Rd5, MS5, OK5,True]
        ]
        else:
            #Viga de alma esbelta: Anexo H
            
            EL1, EL2, EL3, EL4, EL5 = 'Escoamento da Mesa Tracionada', 'Flambagem Lateral com Torcao', 'Flambagem Local da Mesa', 'Area da Alma', 'Esbeltez da Alma'
            Sd1, Sd2, Sd3, Sd4, Sd5 = MSd, MSd, MSd, h*tw, h/tw
            Rd1, Rd2, Rd3, Rd4, Rd5 = 0.0, 0.0, 0.0, 0.0, 0.0
            OK1, OK2, OK3, OK4, OK5 = False, False, False, False, False

            Rd4 = 10*bf*tf #NBR8800: Item H.1.3b            
            Rd51 = 260 #NBR8800: Item H.1.3c
            if(a/h > 1.5): #NBR8800: Item H.1.3c
                Rd52 = 0.42*(self.E)/fy
            else:
                Rd52 = 11.7*math.sqrt((self.E)/fy)
            Rd5 = min(Rd51, Rd52)
        
            #Estado-limite EMT (Escoamento da Mesa Tracionada)
            Rd1 = Wx*fy/gamma1 #NBR8800: Item H.2.1
                
            #Estado-limite FLT + FLA(Flambagem Lateral com Torcao e Flambagem Local da Alma)
            ar = h*tw/(bf*tf)
            kpg = 1-ar/(1200+300*ar)*(h/tw-5.7*math.sqrt((self.E)/fy)) #NBR8800: Item H.2.2
            if (kpg > 1):
                kpg=1;
                 
            IyT = 1/12*(h*tw**3/6 + tf*bf**3)
            AyT = h*tw/6 + bf*tf
            ryT = math.sqrt(IyT/AyT) #NBR8800: Item H.2.2
            if (L==0):
                Rd2 = 'N/A'
                OK2 = True
            else:
                LambdaFLT = L/ryT #NBR8800: Item H.2.2
                LambdapFLT = 1.1*math.sqrt((self.E)/fy) #NBR8800: Item H.2.2
                LambdarFLT = math.pi*math.sqrt((self.E)/(0.7*fy)) #NBR8800: Item H.2.2
                if (LambdaFLT <= LambdapFLT):
                    Rd2 = kpg*Wx*fy/gamma1 #NBR8800: Item H.2.2a
                else:
                    if(LambdaFLT <= LambdarFLT):
                        Rd2 = Cb*kpg/gamma1*(1-0.3*(LambdaFLT-LambdapFLT)/(LambdarFLT-LambdapFLT))*Wx*fy #NBR8800: Item H.2.2b
                    else:
                        Rd2 = Cb*kpg*(math.pi)**2*(self.E)*Wx/(gamma1*LambdaFLT**2) #NBR8800: Item H.2.2c
                    
            #Estado-limite FLM + FLA(Flambagem Local da Mesa e Flambagem Local da Alma)
            LambdaFLM = bf/(2*tf) #NBR8800: Item H.2.3
            LambdapFLM = 0.38*math.sqrt((self.E)/fy) #NBR8800: Item H.2.3
            kc = 4/math.sqrt(h/tw)
            if (kc < 0.35 or kc > 0.76):
                    if(kc < 0.35):
                        kc=0.35
                    else:
                        kc=0.76
            LambdarFLM = 0.95*math.sqrt(kc*(self.E)/(0.7*fy)) #NBR8800: Item H.2.3
            if (LambdaFLM <= LambdapFLM):
                Rd3 = kpg*Wx*fy/gamma1 #NBR8800: Item H.2.3a
            else:
                if (LambdaFLM <= LambdarFLM):
                    Rd3 = kpg*Wx*fy/gamma1*(1-0.3*(LambdaFLM-LambdapFLM)/(LambdarFLM-LambdapFLM)) #NBR8800: Item H.2.3b
                else:
                    Rd3 = 0.9*kpg*(self.E)*kc*Wx/(gamma1*LambdaFLM**2) #NBR8800: Item H.2.3c
        
            #Verificacao do EL1
            if (Sd1 <= Rd1): 
                OK1 = True
            #Verificacao do EL2
            if (Rd2 is not 'N/A' and Sd2 <= Rd2): 
                OK2 = True
            #Verificacao do EL3
            if (Sd3 <= Rd3): 
                OK3 = True
            #Verificacao do EL4
            if (Sd4 <= Rd4): 
                OK4 = True
            #Verificacao do EL5
            if (Sd5 <= Rd5): 
                OK5 = True   
            #Margem de Segurança de EL1
            MS1 = round(100*(Rd1/Sd1-1),2)
            #Margem de Segurança de EL2
            if (Rd2 is not 'N/A'):
                MS2 = round(100*(Rd2/Sd2-1),2)
            else:
                MS2 = 'N/A'
            #Margem de Segurança de EL3
            MS3 = round(100*(Rd3/Sd3-1),2)
            #Margem de Segurança de EL4
            MS4 = round(100*(Rd4/Sd4-1),2)
            #Margem de Segurança de EL5
            MS5 = round(100*(Rd5/Sd5-1),2)
                
            return [
            [EL1, Sd1, Rd1, MS1, OK1,True],
            [EL2, Sd2, Rd2, MS2, OK2,True],
            [EL3, Sd3, Rd3, MS3, OK3,True],
            [EL4, Sd4, Rd4, MS4, OK4,True],
            [EL5, Sd5, Rd5, MS5, OK5,True]
        ]

    def verificarFletorY(self,Cb,fy,fu,d,bf,tf,tw,h,hw,ry,Zy,gamma1,Iy,J,Cw,Wy,Afn,MSd):
        EL1, EL2, EL3, EL4 = 'Flambagem Local da Mesa', 'Flambagem Local da Alma', 'Analise Elastica', 'Ruptura da Mesa Tracionada'
        Sd1, Sd2, Sd3, Sd4 = MSd, MSd, MSd, MSd
        Rd1, Rd2, Rd3, Rd4 = 0.0, 0.0, 1.5*Wy*fy/gamma1, 0.0
        OK1, OK2, OK3, OK4 = False, False, False, False

        #Transformacao de unidade de mm para cm
        d=d/10
        bf=bf/10
        tf=tf/10
        tw=tw/10
        h=h/10
        hw=hw/10
        
        Lambda = h/tw #NBR8800: Tabela G.1, Estado-limite FLA
        #Verificacao da esbeltez
        if Lambda <= 1.4*math.sqrt((self.E)/fy): #NBR8800: Tabela G.1, Estado-limite FLA
            #Viga de alma nao-esbelta:Anexo G
            
            #Estado-limite FLM (Flambagem Local da Mesa)
            LambdaFLM = bf/(2*tf) #NBR8800: Tabela G.1
            LambdapFLM = 0.38*math.sqrt((self.E)/fy) #NBR8800: Tabela G.1
            kc = 4/math.sqrt(h/tw)
            if (kc < 0.35 or kc > 0.76):
                if(kc < 0.35):
                    kc=0.35
                else:
                    kc=0.76
            LambdarFLM = 0.95*math.sqrt((self.E)*kc/(0.7*fy)) #NBR8800: Tabela G.1
            MplFLM = Zy*fy
            MrFLM = 0.7*fy*Wy
            McrFLM = 0.9*(self.E)*kc*Wy/LambdaFLM**2
            if (LambdaFLM <= LambdapFLM):
                Rd1 = MplFLM/gamma1 #NBR8800: Item G.2.2a
            else:
                if (LambdaFLM <= LambdarFLM):
                    Rd1 = (MplFLM-(MplFLM-MrFLM)*(LambdaFLM-LambdapFLM)/(LambdarFLM-LambdapFLM))/gamma1 #NBR8800: Item G.2.2b
                else:
                    Rd1 = McrFLM/gamma1 #NBR8800: Item G.2.2c
            
                    
            #Estado-limite FLA (Flambagem Local da Alma)
            Rd2 = 'N/A' #FLA nao se aplica a perfil I quando fletido em torno do eixo de menor inercia
            OK2 = True
            
            #Estado-limite Ruptura da Mesa Tracionada
            if (fy/fu <= 0.8):
                Yt = 1
            else:
                Yt = 1.1
            if (fu*Afn < Yt*fy*bf*tf):
                Rd4 = fu*Afn*Wy/(gamma1*bf*tf)
            else:
                Rd4 = 'N/A'
                OK4 = True
                
            #Verificacao do EL1
            if (Sd1 <= Rd1): 
                OK1 = True
            #Verificacao do EL3
            if (Sd3 <= Rd3): 
                OK3 = True
            #Verificacao do EL4
            if (Rd4 is not 'N/A' and Sd4 <= Rd4): 
                OK4 = True
            #Margem de Segurança de EL1 
            MS1 = round(100*(Rd1/Sd1-1),2)
            #Margem de Segurança de EL2
            MS2 = 'N/A'
            #Margem de Segurança de EL3 
            MS3 = round(100*(Rd3/Sd3-1),2)
            #Margem de Segurança de EL4
            if (Rd4 is not 'N/A'):
                MS4 = round(100*(Rd4/Sd4-1),2)
            else:
                MS4 = 'N/A'    
            return [
            [EL1, Sd1, Rd1, MS1, OK1,True],
            [EL2, Sd2, Rd2, MS2, OK2,True],
            [EL3, Sd3, Rd3, MS3, OK3,True],
            [EL4, Sd4, Rd4, MS4, OK4,True]
        ]
        else:
            #NBR8800: Viga de alma esbelta:Anexo H
            Rd1 = 'N/A'
            Rd2 = 'N/A'
            Rd3 = 'N/A'
            Rd4 = 'N/A'
            OK1 = True
            OK2 = True
            OK3 = True
            OK4 = True
            MS1 = 'N/A'
            MS2 = 'N/A'
            MS3 = 'N/A'
            MS4 = 'N/A'
            
            return [
            [EL1, Sd1, Rd1, MS1, OK1,False],
            [EL2, Sd2, Rd2, MS2, OK2,False],
            [EL3, Sd3, Rd3, MS3, OK3,False],
            [EL4, Sd4, Rd4, MS4, OK4,False]
        ]


    def verificarCorteY(self,fy,d,bf,tf,tw,h,hw,gamma1,kv,VSd):
        EL1 = 'Escoamento e Flambagem'
        Sd1 = VSd
        Rd1 = 0.0
        OK1 = False

        #Transformacao de unidade de mm para cm
        d=d/10
        bf=bf/10
        tf=tf/10
        tw=tw/10
        h=h/10
        hw=hw/10
        
        Lambda = h/tw #NBR8800: Item 5.4.3.1.1
        Lambdap = 1.1*math.sqrt(kv*(self.E)/fy) #NBR8800: Item 5.4.3.1.1
        Lambdar = 1.37*math.sqrt(kv*(self.E)/fy) #NBR8800: Item 5.4.3.1.1
        Aw = d*tw #NBR8800: Item 5.4.3.1.2
        Vpl = 0.6*Aw*fy #NBR8800: Item 5.4.3.1.2
        if(Lambda <= Lambdap):
            Rd1 = Vpl/gamma1 #NBR8800: Item 5.4.3.1.1
        else:
            if(Lambda <= Lambdar):
                Rd1 = Lambdap*Vpl/(Lambda*gamma1) #NBR8800: Item 5.4.3.1.1
            else:
                Rd1 = 1.24*(Lambdap/Lambda)**2*Vpl/gamma1 #NBR8800: Item 5.4.3.1.1

        #Verificacao do EL1
        if (Sd1 <= Rd1): 
            OK1 = True
        #Margem de segurança do EL1
        MS1 = round(100*(Rd1/Sd1-1),2) 
            
        return [
            [EL1, Sd1, Rd1, MS1, OK1,True],
        ]

    def verificarCorteX(self,fy,d,bf,tf,tw,h,hw,gamma1,VSd):
        EL1 = 'Escoamento e Flambagem'
        Sd1 = VSd
        Rd1 = 0.0
        OK1 = False

        #Transformacao de unidade de mm para cm
        d=d/10
        bf=bf/10
        tf=tf/10
        tw=tw/10
        h=h/10
        hw=hw/10
        
        Lambda = bf/(2*tf) #NBR8800: Item 5.4.3.5 e Item 5.4.3.1.1
        kv = 1.2 #NBR8800: Item 5.4.3.5 e Item 5.4.3.1.1
        Lambdap = 1.1*math.sqrt(kv*(self.E)/fy) #NBR8800: Item 5.4.3.5 e Item 5.4.3.1.1
        Lambdar = 1.37*math.sqrt(kv*(self.E)/fy) #NBR8800: Item 5.4.3.5 e Item 5.4.3.1.1
        Aw = 2*bf*tf #NBR8800: Item 5.4.3.5
        Vpl = 0.6*Aw*fy #NBR8800: Item 5.4.3.5 e Item 5.4.3.1.2
        if(Lambda <= Lambdap):
            Rd1 = Vpl/gamma1 #NBR8800: Item 5.4.3.1.1
        else:
            if(Lambda <= Lambdar):
                Rd1 = Lambdap*Vpl/(Lambda*gamma1) #NBR8800: Item 5.4.3.1.1
            else:
                Rd1 = 1.24*(Lambdap/Lambda)**2*Vpl/gamma1 #NBR8800: Item 5.4.3.1.1
                
        #Verificacao do EL1
        if (Sd1 <= Rd1): 
            OK1 = True
        #Margem de segurança do EL1
        MS1 = round(100*(Rd1/Sd1-1),2)
        
        return [
            [EL1, Sd1, Rd1, MS1, OK1,True],
        ]



            

                            
