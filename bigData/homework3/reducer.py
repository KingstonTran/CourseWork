#!/usr/bin/python
import sys
import pandas as pd
dict1 = {}
columns = ['preg','plas','pres','skin','insu','mass','pedi','age','class']
for myline in sys.stdin:
    myline = myline.strip()
    words = myline.split('\t')
    if (words[0] not in columns):
        columns.append(words[0])
    elif (words[1] not in columns):
        columns.append(words[1])
    pairWord = words[0] + ',' + words[1]
    if (pairWord not in dict1):
        dict1[pairWord] = [[float(words[2])], [float(words[3])]]
    else:
        dict1[pairWord][0].append(float(words[2]))
        dict1[pairWord][1].append(float(words[3]))

for key, value in dict1.items():
    words = key.split(',')
    seriesA  = pd.Series(value[0])
    seriesB = pd.Series(value[1]) 
    print "%s\t%s" % (key, str(seriesA.corr(seriesB)))
