# Change Risk Anti-Patterns (CRAP) Index

El índice CRAP se calcula en base a la complejidad ciclomática y a la cobertura de código. Está diseñado para analizar y predecir la cantidad de esfuerzo, dolor y tiempo requerido para mantener un trozo de código.
    
Aquel código que no sea muy complejo y esté bien cubierto por los tests, tendrá un índice CRAP bajo. El CRAP se puede reducir, por lo tanto, escribiendo tests y refactorizando el código para reducir la complejidad
  
Un método con un índice CRAP de más de 30 se considera CRAPpy (es decir, inaceptable, ofensivo, etc.).

http://gmetrics.sourceforge.net/gmetrics-CrapMetric.html