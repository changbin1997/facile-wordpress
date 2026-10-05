# Facile-WordPress

[English](README.md) | [简体中文](README.zh.md) | [日本語](README.ja.md) | **Español**

Facile es un tema de blog limpio y minimalista para WordPress y Typecho, y también es el tema que uso actualmente en mi propio blog.

Actualmente estás viendo la versión para WordPress del tema. Si buscas la versión para Typecho, puedes encontrarla en [https://github.com/changbin1997/Facile](https://github.com/changbin1997/Facile).

## Enlaces relacionados

Demo del tema: [https://www.misterma.com/](https://www.misterma.com/)

Descarga del tema: [https://github.com/changbin1997/facile-wordpress/releases](https://github.com/changbin1997/facile-wordpress/releases)

Guía de uso: [https://www.misterma.com/archives/952/](https://www.misterma.com/archives/952/)

Si encuentras algún problema o error al usar el tema, puedes dejar un mensaje en [mi blog](https://www.misterma.com/archives/952/) o reportarlo en [GitHub Issues](https://github.com/changbin1997/facile-wordpress/issues).

## Capturas de pantalla

Tema claro:

![Tema claro](screenshot.png)

Tema oscuro:

![Tema oscuro](screenshots/dark.png)

Imagen destacada grande:

![Imagen destacada grande](screenshots/large.png)

## Características

* Diseño adaptable (responsive) para una visualización perfecta en cualquier dispositivo
* Compatibilidad con accesibilidad para garantizar una experiencia inclusiva
* Esquemas de color claro y oscuro con ajuste automático según la configuración del sistema
* Resaltado de código integrado, ideal para desarrolladores y entusiastas de la tecnología
* Soporte de MathJax para representar fórmulas matemáticas
* Múltiples diseños de lista de artículos entre los que elegir
* Amplias opciones de personalización para adaptar el tema a tus necesidades
* [Documentación](https://www.misterma.com/archives/952/) detallada que te guía en la instalación y el uso
* Mantenimiento activo para garantizar su fiabilidad a largo plazo

## Instalación

WordPress exige requisitos estrictos para el desarrollo de temas, y el nuestro se está ajustando actualmente para cumplir esas pautas. Una vez finalizados los ajustes, se enviará al directorio oficial de temas. Por ahora, el tema debe descargarse e instalarse manualmente.

### Método 1

1. Ve a la página de [Releases](https://github.com/changbin1997/facile-wordpress/releases) y descarga la última versión de Facile en un archivo ZIP.
2. Inicia sesión en el panel de administración de WordPress y ve a `Apariencia` - `Temas`.
3. Haz clic en `Añadir nuevo tema` y después en `Subir tema`. Selecciona el archivo ZIP descargado y haz clic en `Instalar ahora`.
4. Cuando termine la instalación, haz clic en `Ir a la página de temas`. Deberías ver el tema Facile; haz clic en `Activar` para habilitarlo.

### Método 2

1. Ve a la página de [Releases](https://github.com/changbin1997/facile-wordpress/releases) y descarga la última versión de Facile en un archivo ZIP.
2. Sube el tema al directorio `wp-content/themes` de tu instalación de WordPress.
3. Descomprime el archivo ZIP de Facile. Después de extraerlo, deberías ver una carpeta llamada `facile`.
4. Inicia sesión en el panel de administración de WordPress y ve a `Apariencia` - `Temas`. El tema Facile debería aparecer ahora; haz clic en `Activar` para habilitarlo.

## Desarrollo y dependencias

El tema utiliza las siguientes bibliotecas:

* [bootswatch](https://github.com/thomaspark/bootswatch) - Una colección de temas elegantes para Bootstrap
* [jQuery](https://jquery.com/) - Para la manipulación del DOM y como dependencia de Bootstrap
* [highlight.js](https://highlightjs.org/) - Para el resaltado de sintaxis del código
* [clipboard.js](https://github.com/zenorocha/clipboard.js) - Para copiar el código con un solo clic

En el backend de PHP no se utiliza ninguna biblioteca adicional.

Los iconos del tema provienen de [IcoMoon](https://icomoon.io/), una biblioteca de iconos tipográficos personalizables. Como los iconos de IcoMoon se pueden personalizar, el tema solo incluye los iconos que realmente utiliza, lo que lo mantiene ligero.

## Widgets de la barra lateral

Facile es totalmente compatible con los widgets de barra lateral incluidos en WordPress. Además de los widgets estándar, Facile añade los siguientes widgets personalizados:

* **Selector de modo de color de Facile**: Permite a los visitantes cambiar manualmente entre el modo claro y el oscuro. El modo elegido se guarda localmente mediante cookies, de modo que cuando el usuario vuelva a visitar el sitio verá el color que seleccionó.
* **Comentarios recientes de Facile**: Una versión más sencilla y accesible del widget estándar de comentarios recientes, pensada para mejorar la usabilidad.
* **Nube de etiquetas de Facile**: Un widget de nube de etiquetas colorido y con mejor accesibilidad, que ofrece una experiencia visualmente atractiva y fácil de usar.

Los widgets añadidos por Facile empiezan por "Facile", por lo que resultan fáciles de identificar.

## Accesibilidad

Navegar por la web es algo sencillo para la mayoría de las personas, pero puede resultar muy difícil para quienes tienen alguna discapacidad.

Facile está diseñado pensando en la accesibilidad e incorpora numerosas optimizaciones para lectores de pantalla. Se ha probado con [NVDA](http://www.nvda-project.org/) y [VoiceOver](https://www.apple.com/accessibility/iphone/vision/) en ordenadores y dispositivos móviles, y ambos leen el contenido a la perfección. El tema transmite con precisión el contenido y la información que deben leerse, de modo que las personas ciegas pueden manejarlo sin problemas con un lector de pantalla estándar.

El tema también es totalmente compatible con la navegación por teclado y su contraste de color cumple los estándares recomendados.

## Compatibilidad

El tema utiliza pocas funciones de CSS3 y es totalmente compatible con los navegadores más comunes. En el caso de Internet Explorer, se necesita la versión IE10 o posterior para una compatibilidad perfecta.

El JavaScript está escrito en ES6. La versión publicada (empaquetada) es totalmente compatible con IE, mientras que la versión de desarrollo no admite Internet Explorer ni los navegadores más antiguos.