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
app/Models --> Las entidades en la base de datos.
database/migrations --> Migraciones requeridas.


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
http://localhost:24889/eloquent-demo
```

3. Si quieres recrear la base de datos dentro del contenedor:

```bash
docker compose exec app php artisan migrate:fresh
```

### Consulta de ejemplo

Se puede revisar la ruta `GET /eloquent-demo` para ver consultas Eloquent con relaciones, filtros, ordenamiento y una consulta con eager loading para evitar N+1.

