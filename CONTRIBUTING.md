# 👷 Projetando SportFinder

## 1. Instalação e Execução
```
git clone https://github.com/seuRepo/sportfinderbackend
cd sportFinderBackend
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
```

## 2. Verificação
- Verifique se o .env foi criado e esta correto
- Verifique se as tabelas foram criadas corretamente

## 3. Rotas para teste
- Praticamente todas as rotas estão protegidas para serem acessadas apenas com login.
```
http://localhost/api/register
{
  "name": "admin",
  "email": "admin@email.com",
	"password": "123456789",
	"password_confirmation": "123456789",
	"perfil": "admin",
	"documento": "1234567891"
}
--
http://localhost/api/login
{
	"email": "admin@email.com",
	"password": "123456789"
}
--
//para acessar a seguinte rota, deve consumir o Token disponibilizado pela rota de login
http://127.0.0.1:8000/api/areas
```
