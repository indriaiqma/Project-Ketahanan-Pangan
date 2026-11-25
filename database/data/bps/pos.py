import sys
from collections import defaultdict
from pypdf import PdfReader
def baris(page):
    items=[]
    def v(text,cm,tm,fd,fs):
        if not text.strip(): return
        # posisi efektif = tm * cm
        a,b,c,d,e,f=tm; A,B,C,D,E,F=cm
        x=e*A+f*C+E; y=e*B+f*D+F
        rot = abs(b)>0.01 or abs(c)>0.01   # teks miring = watermark
        items.append((round(y,1),round(x,1),text.strip(),rot,fs))
    page.extract_text(visitor_text=v)
    rows=defaultdict(list)
    for y,x,t,rot,fs in items:
        if rot: continue
        rows[round(y/3)].append((x,t))
    return [sorted(rows[k]) for k in sorted(rows,reverse=True)]
if __name__=='__main__':
    r=PdfReader(sys.argv[1])
    for i,p in enumerate(r.pages):
        t=p.extract_text() or ''
        if sys.argv[2] in t:
            print('=== page',i)
            for row in baris(p): print(' | '.join(f'{t}@{int(x)}' for x,t in row))
            break
