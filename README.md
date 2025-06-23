# Algoritmo de Bellman-Ford em PHP

Este repositório contém uma implementação do algoritmo de Bellman-Ford em PHP. O algoritmo de Bellman-Ford é utilizado para encontrar os caminhos mais curtos de um único vértice de origem para todos os outros vértices em um grafo ponderado. Sua principal vantagem sobre outros algoritmos como o Dijkstra é a capacidade de lidar com **pesos de arestas negativos**. Além disso, ele é capaz de **detectar a presença de ciclos de peso negativo** no grafo.

---

## Funcionalidades

* **Entrada de Grafo Dinâmica**: Permite que o usuário defina o número de vértices e arestas, e então insira cada aresta (origem, destino, peso) interativamente via terminal.
* **Detecção de Ciclos Negativos**: Alerta o usuário se o grafo contiver um ciclo de peso negativo alcançável a partir do nó de origem, onde caminhos mais curtos não podem ser definidos.
* **Exibição do Grafo**: Mostra a representação das arestas do grafo que foi digitado.
* **Caminhos Mais Curtos**: Calcula e exibe a distância mais curta do nó de origem para cada outro vértice.
* **Reconstrução do Caminho**: Apresenta o trajeto (sequência de vértices) do caminho mais curto para cada vértice.

---

## Como Usar

Para executar este algoritmo, você precisará ter o **PHP instalado** em seu sistema.

1.  **Clone o Repositório** (ou copie o código do arquivo `bellman_ford.php` para o seu computador):

    ```bash
    git clone [https://github.com/JonathanBufon/bellman_ford_input](https://github.com/JonathanBufon/bellman_ford_input)
    cd bellman_ford_input
    ```

2.  **Execute o Script PHP**:
    Abra seu terminal ou prompt de comando, navegue até o diretório onde o arquivo `bellman_ford.php` está salvo e execute o seguinte comando:

    ```bash
    php bellman_ford.php
    ```

3.  **Interaja com o Programa**:
    O programa irá guiá-lo através da entrada dos dados do grafo:
    * Primeiro, você será solicitado a informar o **número total de vértices** do grafo (os vértices são indexados a partir de 0).
    * Em seguida, digite o **número de arestas**.
    * Para cada aresta, o programa pedirá a **origem**, o **destino** e o **peso**, separados por espaços (ex: `0 1 5`).
    * Por fim, informe o **nó de origem** a partir do qual você deseja calcular os caminhos mais curtos.

---

## Exemplo de Execução

Aqui está um exemplo de interação com o programa e seus respectivos resultados:

```bash
┌──(cosmos㉿dell-laptop)-[~/Documentos/unochapeco/bellman-ford]
└─$ php bellman_ford_input.php

Bem-vindo ao calculador de grafo Bellman-Ford!
Os vértices são indexados a partir de 0.

Digite o número de vértices no grafo: 5
Digite o número de arestas no grafo: 8

Agora, insira as arestas. Para cada aresta, digite 'origem destino peso' (ex: 0 1 5).
Os vértices devem estar no intervalo [0, 4].
Aresta 1: 0 1 -1
Aresta 2: 0 2 4
Aresta 3: 1 2 3
Aresta 4: 1 3 2
Aresta 5: 1 4 2
Aresta 6: 3 2 5
Aresta 7: 3 1 1
Aresta 8: 4 3 -3

--- Grafo Digitado ---
Número de Vértices: 5
Arestas (Origem -> Destino [Peso]):
  0 -> 1 [-1]
  0 -> 2 [4]
  1 -> 2 [3]
  1 -> 3 [2]
  1 -> 4 [2]
  3 -> 2 [5]
  3 -> 1 [1]
  4 -> 3 [-3]
----------------------

Digite o nó de origem para o cálculo do Bellman-Ford: 0

--- Resultados do Bellman-Ford ---
Nó de Origem: 0

Para Vértice 0:
  Distância: 0
  Caminho: 0 (Origem)

Para Vértice 1:
  Distância: -1
  Caminho: 0 -> 1

Para Vértice 2:
  Distância: 2
  Caminho: 0 -> 1 -> 2

Para Vértice 3:
  Distância: -2
  Caminho: 0 -> 1 -> 4 -> 3

Para Vértice 4:
  Distância: 1
  Caminho: 0 -> 1 -> 4
---------------------------------

```


