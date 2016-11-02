'''
    script usado pelo Eiffel para obter parametros e selecionar as classes de calculo
'''
import sys,json

pythonPath, jsonReturn = "C:\python33\python.exe", []

#componente,secao,parametros = input().split(" ")
#print(secao)

if sys.argv:
    #try:
    if True:
        secao,funcao,parametros = sys.argv[1],sys.argv[2],[float(p) for p in sys.argv[3].split(',')]
        secaoClass = getattr(__import__(secao),secao)
        jsonReturn = getattr(secaoClass,funcao)(secaoClass,*parametros)
    #except:
    #    jsonReturn = []

print(json.dumps(jsonReturn))
