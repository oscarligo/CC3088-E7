## CC3088 - BASES DE DATOS 1

## Diseño de Base de Datos con ORM

### Dominio elegido: Plataforma de cursos online

Este laboratorio modela un sistema tipo Udemy o Platzi con estas 10 tablas:


| Tabla | Propósito | Campos clave |
| --- | --- | --- |
| users | Estudiantes y profesores | name, email, role, password |
| profiles | Información extra del usuario | user_id, bio, avatar_url, birth_date, social_links |
| categories | Categorías de cursos | name, slug |
| courses | Cursos principales del sistema | teacher_id, category_id, level_id, title, slug, description, price, is_published, published_at |
| lessons | Lecciones de cada curso | course_id, title, content, video_url, position |
| reviews | Calificaciones y comentarios | user_id, course_id, rating, comment |
| levels | Nivel del curso | name, slug |
| tags | Etiquetas del curso | name, slug |
| course_tag | Tabla pivote N:N | course_id, tag_id |
| enrollments | Inscripciones de usuarios | user_id, course_id, enrolled_at, status, price_paid |


### Estructura importante: 
- app/Models --> Las entidades en la base de datos.
- database/migrations --> Migraciones requeridas.
- app/Http/Controllesr/EloquentDemoController.php --> Ejemplo de queriso de los requisitos. 

### Migraciones del dominio

Las migraciones del laboratorio documentan 10 tablas del dominio principal:

| Migración | Tabla | Propósito |
| --- | --- | --- |
| 0001_01_01_000000_create_users_table.php | users, password_reset_tokens, sessions | Autenticación y sesiones |
| 0001_01_01_000003_create_profiles_table.php | profiles | Información adicional del usuario |
| 0001_01_01_000004_create_categories_table.php | categories | Clasificación de cursos |
| 0001_01_01_000005_create_levels_table.php | levels | Nivel de dificultad |
| 0001_01_01_000006_create_tags_table.php | tags | Etiquetas temáticas |
| 0001_01_01_000007_create_courses_table.php | courses | Entidad principal del sistema |
| 0001_01_01_000008_create_lessons_table.php | lessons | Lecciones por curso |
| 0001_01_01_000009_create_reviews_table.php | reviews | Calificaciones y comentarios |
| 0001_01_01_000010_create_enrollments_table.php | enrollments | Inscripciones de usuarios |
| 0001_01_01_000011_create_course_tag_table.php | course_tag | Relación many-to-many curso-etiqueta |

Puntos importantes de diseño:
- `profiles.user_id` usa `unique()` para forzar una relación 1:1.
- `courses.teacher_id`, `courses.category_id` y `courses.level_id` representan las FKs del modelo central.
- `reviews` y `enrollments` usan claves compuestas únicas para evitar duplicados.
- `course_tag` usa clave primaria compuesta para la pivote many-to-many.
- Se usan tipos de columna como `json`, `decimal`, `boolean`, `date` y `timestamp` para reflejar el dominio.


### Relaciones importantes

- `users` tiene una relación 1:1 con `profiles`.
- `users` tiene relación 1:N con `courses` como profesor.
- `categories` tiene relación 1:N con `courses`.
- `levels` tiene relación 1:N con `courses`.
- `courses` tiene relación 1:N con `lessons`, `reviews` y `enrollments`.
- `courses` tiene relación N:N con `tags` mediante `course_tag`.
- `users` tiene relación 1:N con `enrollments` y `reviews`.

### Ejecutar con Docker

1. Construir y levantar el contenedor:

```bash
docker compose up --build
```

2. Abrir la ruta de demostración:

```bash
http://localhost:8000/eloquent-demo
```


### Consulta de ejemplo

Se puede revisar la ruta `GET /eloquent-demo` para ver consultas Eloquent con relaciones, filtros, ordenamiento y una consulta con eager loading para evitar N+1.

