# Missão (phpdev2016)
![missaoimpossivel3.gif](img/missaoimpossivel3.gif)

## Sua missão, caso deseje aceitá-la:
A aplicação **SimplesVet Lite** está evoluindo e precisa de 3 novas funcionalidades: 

1. O animal está sem proprietário... =(  Crie um cadastro para `Proprietários`  com `Nome`, `email` e `telefone`; Depois atualize a tela de `Animais` para que ela receba o `Proprietário`
2.  Para que seja mais fácil identificar os animais, os clientes estão pedindo que seja colocada uma `foto` para o animal. Pensando em  adaptar a todos os dispositivos, a imagem de ter no máximo `200x200px` e deve ser quadrada.
3. Por último, os animais precisam ser vacinados!! Crie um lugar onde seja possível aplicar uma vacina para o animal (já tem tabela! Veja na sessão [*estrutura de dados*](#estrutura)).


![missaoimpossivel4.gif](img/missaoimpossivel4.gif)

## Go further! 
Se quiser ir **além** e mostrar que *Tom Cruise* é licuri, aqui vão algumas coisas divertidas:
 
1. No upload da imagem do animal, coloque um recurso que permita o usuário gerar um `thumb` com crop e dimensões `50x50px`. 
2. A aplicação e a API estão sem controle de acesso... o.O

Fique livre para propor/implementar outras novidades bacanas. Seja de funcionalidade ou estrutura de código.

![missaoimpossivel5.gif](img/missaoimpossivel5.gif)

## Como entregar

1. Faça um fork desse repositório
2. Publique a aplicação rodando em algum servidor seu ou um free como o [Heroku](https://www.heroku.com/).

## Hard mode on!

1. Ta afim de se destacar? Crie uma conta na [AWS (é free por 1 ano)](https://aws.amazon.com/pt/free/) e crie toda infra pra aplicação lá... Para que possamos validar, nos passe um usuário que possa visualizar essa infra. 
2. O ideal é que as imagens não fiquem no servidor de aplicação, então as imagens dos animais devem ir para um bucket no `AWS S3`. =)

![missaoimpossivel1.gif](img/missaoimpossivel1.gif)


----
### <a name="estrutura"></a>Estrutura de dados
Para acelerar e te dar uma idéia do padrão que usamos, já entregamos uma estrutura básica de banco com tabelas, views e procedures:


![schema.png](db/schema.png)

### Estrutura da Aplicação
Separamos em 2 pastas: `api` e `app`. Na pasta `app` Existe uma aplicação em PHP sem uso de nenhum framework, apenas uma lib criada por nós chamada `Genesis`. Na `api`, usamos o Slim Framework para criar os endpoints e o `Genesis` para acesso ao banco e algumas funções.

### Setup
Para saber como colocar a aplicação pra funcionar, acesse o arquivo [SETUP.md](SETUP.md)

### Template
Para interface do exemplo, foi usado o template [Metronic](http://keenthemes.com/preview/metronic/theme/admin_3/). Acesse o link para visualizar todos os recursos disponíveis no template.

---

Essa mensagem se autodestruirá em 5, 4, 3, 2, 1....


![missaoimpossivel2.gif](img/missaoimpossivel2.gif)
