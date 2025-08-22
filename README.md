# Hiragana Practice Web

Este proyecto es una aplicación web sencilla para practicar **símbolos del alfabeto japonés hiragana**
El objetivo es que el usuario pueda mejorar su reconocimiento de caracteres, asociando cada símbolo con su lectura en **romaji**

---

##  Mecánica del juego

1. Al cargar la página, aparece un **símbolo hiragana** al azar.
2. El usuario debe escribir en el campo de texto la lectura en **romaji**.
3. Al presionar el botón de verificar:
   -  Si es correcto:  
     - Se muestra un mensaje de acierto.  
     - Se suma un punto al contador de aciertos.  
     - El sistema genera un nuevo símbolo al azar.
   -  Si es incorrecto:  
     - Se muestra un mensaje de error.  
     - El contador de aciertos se reinicia a **0**.  
     - El mismo símbolo permanece hasta que el usuario lo acierte.

---

## Funcionamiento técnico

- **Frontend (Vista):**  
  Una página en HTML con un formulario que permite al usuario introducir la respuesta.  
  La interfaz se actualiza dinámicamente para mostrar:
  - El símbolo actual en hiragana.
  - El mensaje de acierto/error.
  - El contador de aciertos acumulados.

- **Backend (Controlador + Modelo):**  
  Implementado en **PHP**, encargado de:
  - Seleccionar un símbolo aleatorio desde la base de datos.  
  - Comparar la respuesta del usuario con la lectura correcta.  
  - Actualizar la sesión para llevar el control de:
    - El símbolo actual.
    - El contador de aciertos.
    - El estado del último intento (correcto/incorrecto).

- **Base de datos:**  
  Implementada en **MySQL**, con una tabla `HiraganaCharacter` que contiene:
  - `Hcid` → ID del símbolo.  
  - `HCCharacter` → El símbolo en hiragana.  
  - `HCromaji` → Su transcripción en romaji.  

---

## Requisitos

- Servidor web con soporte **PHP** (ej. XAMPP, Laragon, Apache+PHP).  
- Servidor de base de datos **MySQL**.  
- Un navegador moderno (Chrome, Firefox, Edge, etc.).

---

## Instalación

1. Clonar o descargar este repositorio en tu servidor local.  
2. Importar el archivo SQL con los símbolos de hiragana en tu base de datos.  
3. Configurar la conexión a MySQL en el archivo PHP (usuario, contraseña y nombre de la base).  
4. Abrir la aplicación en el navegador (ej. `http://localhost/hiragana-practice`).  

---

## Futuras mejoras que quizas algun dia agrege(dudo hacerlo xD)

- Agregar modo de práctica con **katakana**.  
- Implementar un sistema de niveles o tiempo límite.  
- Mostrar estadísticas del progreso del usuario.  

