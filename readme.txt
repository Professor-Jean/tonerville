Padrões de formatação:

--------------------------------------------------------------------------------

Nomes de arquivos: snake_case
Nomes de variáveis: snake_case
Nomes de funções: camelCase

--------------------------------------------------------------------------------

Programação será feita em inglês. Comentários serão em português.

--------------------------------------------------------------------------------

Exemplo de comentários de explicação:
// atribui o valor 2 à variável x
x = 2;

Exemplo de comentários de documentação:
/*
 * Valores de status:
 * 0 - disponível
 * 1 - alugada
 * 2 - retirada
 */

--------------------------------------------------------------------------------

Nomes de páginas: (descrição breve)_(pasta).ext
Exemplo: system/admin/rentals/fmins_rentals.php

--------------------------------------------------------------------------------

Mensagem de acerto:

(nome) (inserido|a / alterado|a / removido|a) com sucesso.

--------------------------------------------------------------------------------

Mensagens de erro:

O campo "(nome)" foi preenchido incorretamente.
Erro na (inserção / alteração / remoção) de (nome).
Existem registros de (nome) associados com esse registro; exclua-os e tente novamente.
Esse registro de (nome) já existe.
(nome) inexistente.

--------------------------------------------------------------------------------

Variáveis de mensagem:

$title
$message

--------------------------------------------------------------------------------

Variáveis de conexão com o banco (para selects):

$sel_(nome) = (instrução sql);
$sel_(nome)_prepared = $db_connection->prepare($sel_(nome));
$sel_(nome)_prepared->execute();
$sel_(nome)_data = $sel_(nome)_prepared->fetch();

--------------------------------------------------------------------------------

Como fazer uma url no carregamento dinâmico:

'?folder=(pasta)&file=(arquivo)&ext=(extensão)'

exemplo: '?folder=addons/php/&file=validations_php&ext=php'