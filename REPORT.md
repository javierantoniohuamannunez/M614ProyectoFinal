
# REPORT – Projecte de Síntesi

## 1. Dades generals

Nom del projecte: Desplegament Laravel - Projecte Javier i Alex

Integrants: Alex i Javier

Tecnologia principal (Laravel / React / Fullstack): Laravel

Enllaç al repositori: https://github.com/javierantoniohuamannunez/M614ProyectoFinal.git

Data d’entrega:

## 2. Estat inicial del projecte

El projecte original era una aplicació **Laravel funcional**, desenvolupada en un altre mòdul. Segons l’enunciat:

> “En aquest projecte recuperareu una aplicació web desenvolupada en un altre mòdul… L’objectiu NO és desenvolupar funcionalitat nova complexa.”  

### Estat inicial detectat:
- L’aplicació funcionava correctament en local.
- No hi havia cap configuració Docker.
- El fitxer `.gitignore` era complet i adequat per a Laravel. Incloïa entrades com:
```
/vendor 
/node_modules 
/public/build
```
- No hi havia cap estructura de branques ni workflow Git professional.
- No hi havia documentació clara d’execució.

### Problemes detectats:
- Falta de Docker → el projecte no era reproduïble en un altre ordinador.
- Falta de workflow Git → tot estava en un únic estat inicial.
- Falta de documentació tècnica.

### Reflexió:
El projecte funcionava, però **no era professional**. Tal com diu l’enunciat:

> “Un projecte no és només funcional quan funciona, sinó quan és segur, mantenible i desplegable sense comprometre dades sensibles.”

---

## 3. Workflow Git aplicat

Hem aplicat un workflow basat en branques:

### Model de branques:
- `main` → branca protegida, només rep merges via Pull Request.
- `feature/...` → noves funcionalitats o tasques.
- `fix/...` → correccions.

### Convencions:
- Noms de branques descriptius:  
- `feature/estructura-inicial`  
- `feature/preparacion-proyecto`
- Missatges de commit curts i clars.

### Estratègia de merge:
- Sempre via Pull Request.
- L’altre membre revisa abans de fer merge.

### Exemples reals de commits:
- “Organizo estructura inicial del projecte”
- “Añado documentación base al README”
- “Creo carpeta docs/ para documentación”

Aquest procés compleix el requisit:

> “El repositori ha d’incloure: ús de branques… mínim 2 Pull Requests o merges documentats.”

## 4. Conflicte 1 – Mateixa línia

### 4.1 Com s’ha provocat

Expliqueu exactament quins canvis ha fet cada membre.

### 4.2 Missatge d’error generat

Incloeu la sortida real de Git.

### 4.3 Marcadors de conflicte

Mostreu el fragment amb:
```
<<<<<<< HEAD
=======
>>>>>>> branch
```
### 4.4 Resolució aplicada

Expliqueu:

- Quina decisió s’ha pres
- Per què s’ha escollit aquesta opció
- Com s’ha validat que funciona

### 4.5 Reflexió

Què heu après d’aquest conflicte?

## 5. Conflicte 2 – Dependències o estructura

### 5.1 Descripció del conflicte

### 5.2 Error generat

### 5.3 Resolució aplicada

### 5.4 Diferències respecte al conflicte anterior

## 6. Dockerització

### 6.1 Arquitectura final

Descriviu els serveis definits a docker-compose.yml.

### 6.2 Variables d’entorn

Expliqueu quines variables són necessàries i per què no es versiona el .env.

### 6.3 Persistència (si s'escau)

Expliqueu l’ús de volums.

###  6.4 Problemes trobats

Incloeu errors reals i com s’han resolt.

## 7. Prova de desplegament des de zero

  Expliqueu els passos exactes que hauria de seguir una persona externa:
- Clonar repositori
- Executar comanda
- Accedir a l’aplicació  

Indiqueu també:
- Ports utilitzats
- Credencials de prova (si n’hi ha)

## 8. Repartiment de tasques

Descriviu què ha fet cada membre de l’equip.

## 9. Temps invertit

Indiqueu aproximadament:
- Temps dedicat a Git
- Temps dedicat a Docker
- Temps dedicat a documentació

## 10. Reflexió final

Responeu breument:

- Quina ha estat la part més complexa?
- Què faríeu diferent en un projecte real?
- Heu entès realment com funcionen els conflictes i Docker?
