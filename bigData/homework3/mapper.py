#!/usr/bin/python
import sys

columns = ['preg','plas','pres','skin','insu','mass','pedi','age','class']
for myline in sys.stdin: 
    words = myline.split(',') 
    words.pop()
    for i in range(0,len(words)):
        for n in range(i,(len(words)-i)):
            if (i != n):
                print '%s\t%s\t%s\t%s' % (columns[i], columns[n], str(words[i]), str(words[n]))

