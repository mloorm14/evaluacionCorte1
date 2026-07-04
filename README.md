# Evaluación Unidad II - Gestión de Materias Seguro (PHP 8.3 + PostgreSQL)

* **Estudiante:** Loor Medranda Marlon Taylor  
* **Cédula:** 0928087469
* **Paralelo:** Ingeniería de Software - 5to Nivel "A"  
* **Fecha:** 2026-07-03  
* **Pila Elegida:** Opción B (PHP 8.3 + PDO PostgreSQL)  
* **Último Commit Hash:** `a7b3c2d`

## Requisitos Previos
* Docker y Docker Desktop 4.x instalado de forma local.

## Credenciales Semilla (Pruebas de Cátedra)
* **Usuario:** `admin`  
* **Contraseña:** `Admin*2026`  
* **URL Local:** http://localhost:8080/login

## Validación de Seguridad
Para inspeccionar las cabeceras de cumplimiento estricto OWASP, ejecute:
```bash
curl -I http://localhost:8080/login
```

## Instrucciones de Ejecución

1. Clone el repositorio e ingrese al directorio ejecutando en terminal: `git clone https://github.com/usuario/materias-aguirre.git && cd materias-aguirre`.
2. Duplique el entorno base para el levantamiento de los contenedores: `cp .env.example .env`.
3. Inicie los servicios aislados de base de datos y servidor web ejecutando: `docker compose up -d --build`.
