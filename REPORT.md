
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
```
En el primer comflicto se genero cuando nostros modificamos la misma linea del mismo archivo del proyecto, que fue en el archivo README.md que se modifico. Yo añadi una descripción del proyecto, mientras que Alex modificó esa misma línea con una explicación diferente.

Cuando se intentó hacer el merge entre las dos ramas, Git detectó que ambos cambios afectaban a la misma línea y generó un conflicto.
```
### 4.2 Missatge d’error generat

Incloeu la sortida real de Git.
![errorConflicto1](../M614ProyectoFinal/imgCaptura/erroConflicto1.png)

### 4.3 Marcadors de conflicte

Mostreu el fragment amb:

![Conflicto1](../M614ProyectoFinal/imgCaptura/Conflicto1.png)


### 4.4 Resolució aplicada

Expliqueu:

```
- Quina decisió s’ha pres
    - Se resolvio manualmente editando el archivo 
- Per què s’ha escollit aquesta opció
    - Decidimos mantener los 2 textos para ver los cambios de los dos
- Com s’ha validat que funciona
    - Despues elimanmos los macadores del comflicto y se guardo el archivo, y se realizo un commit para confirmar la reolición del conflicto 
```


### 4.5 Reflexió

Què heu après d’aquest conflicte?
```
Nos dio a entender como git detecta cambios incopatibles en las mismas lineas de codigo y también aprendimos que trabajar con ramas y revisar los cambios antes de hacer merge ayuda a evitar problemas en proyectos colaborativos.
```
## 5. Conflicte 2 – Dependències o estructura

### 5.1 Descripció del conflicte
```
El segundo conflicto se provocó modificando la estructura del proyecto, uno modificó la configuración del archivo docker-compose.yml mientras que el otro miembro realizaba cambios relacionados con la estructura del proyecto y la configuración de Docker.

Al intentar fusionar las ramas, Git detectó cambios incompatibles en el mismo archivo de configuración.
```
### 5.2 Error generat
```
En el merge Git indicó que existía un conflicto en el archivo docker-compose.yml.
Esto indicaba que ambos miembros habían modificado el mismo bloque de configuración.
```

### 5.3 Resolució aplicada


### 5.4 Diferències respecte al conflicte anterior
```
La principal diferencia con el primer conflicto es que esto afectaba a la configuración del proyecto y no solo a una línea de texto y si no se resolvía correctamente podía provocar errores en el funcionamiento de la aplicación.
```

## 6. Dockerització

### 6.1 Arquitectura final

Descriviu els serveis definits a docker-compose.yml.
```
En el servicio de app lo construimos con el dockerfile que tiene una base de php donde primero instalamos las dependencias de php con el compose, npm, la genrecaion del Vite para los archivos css y javaScript
y tambien una generacion automatica de la clave que se guarda en la variable APP_KEY y migraciones de la ase de datos, el sevidor se expone en el puerto de 8000.
Y en la parte de BD lo ejecutamos con MySQL, que en este contenedor configramos con variables de entorno el nombre de la base de datos, el usuario y la contraseña de usuario
```

### 6.2 Variables d’entorn

Expliqueu quines variables són necessàries i per què no es versiona el .env.
```
En este proyecto se utiliza el archivo .env.example, que sirve como plantilla para configurar la aplicación.
Entre las variables más importantes se encuentran:
 - DB_CONNECTION=mysql
 - DB_HOST=db
 - DB_PORT=3306
 - DB_DATABASE=db_institut
 - DB_USERNAME=alex
 - DB_PASSWORD=alex

 El archivo .env no se versiona en el repositorio, ya que puede contener información sensible como contraseñas, claves o configuraciones específicas del entorno.

En su lugar, se incluye .env.example para que cualquier persona que clone el repositorio pueda crear su propio archivo .env basado en esta plantilla.
```

### 6.3 Persistència (si s'escau)

Expliqueu l’ús de volums.
```
Para garantizar que los datos de la base de datos no se pierdan cuando el contenedor se reinicia, se ha configurado un volumen Docker.

En el archivo docker-compose.yml se define el volumen:

 volumes:
   dbdata:
```

###  6.4 Problemes trobats

Incloeu errors reals i com s’han resolt.
```
En el proceso tuve varios problemas, uno de los primero problemas fue la conexcion entre laravel y base de datos que no estaba configurado correctamente este problema se soliciono cambiando la varible DB_HOST=db en el archivo .env
Luego otro problema fue que no habia una clave en la aplicacion de laravel APP_KEY que cuando querias levantar el servidor nos daba un error que no existia  una clabe de cifrado y se corrigio con este comando 
   
   php artisan key:generate

Luego tuve otro problema con Vite, no habia varios archivos que no existian, y hacia que los archivos del frontend no se compilaban correctamente y para corregir solo se instalaron las dependencias de Node.js con estos comandos

    npm install
    npm run build

Otro problema fue la que falta de Node.js y npm dentro del contenedor Docker, lo que no nos dejaba ejecutar los comandos necesarios para generar las configuración del frontend. Este problema se resolvió modificando el Dockerfile para instalar Node.js y npm dentro del contenedor
```

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
 
```
      Javier
====================================
Git workflow: 2 horas  
Resolución de conflictos: 2 horas  
Dockerización: 4 horas  
Documentación: 2 horas
```
## 10. Reflexió final

Responeu breument:

- Quina ha estat la part més complexa?
- Què faríeu diferent en un projecte real?
- Heu entès realment com funcionen els conflictes i Docker?
