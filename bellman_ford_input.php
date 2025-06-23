<?php

/**
 * Implementação do Algoritmo de Bellman-Ford em PHP.
 * Calcula os caminhos mais curtos a partir de um vértice de origem
 * em um grafo ponderado, incluindo grafos com arestas de peso negativo.
 * Também detecta a presença de ciclos de peso negativo.
 */

class Graph
{
    private $vertices; // Armazena o número de vértices no grafo
    private $edges;    // Armazena as arestas do grafo como uma lista de tuplas (origem, destino, peso)

    /**
     * Construtor da classe Graph.
     * @param int $vertices O número total de vértices no grafo.
     */
    public function __construct(int $vertices)
    {
        $this->vertices = $vertices;
        $this->edges = []; // Inicializa a lista de arestas vazia
    }

    /**
     * Adiciona uma aresta ao grafo.
     * @param int $source O vértice de origem da aresta.
     * @param int $destination O vértice de destino da aresta.
     * @param int $weight O peso da aresta.
     */
    public function addEdge(int $source, int $destination, int $weight)
    {
        // Adiciona a aresta como um array associativo para fácil acesso aos seus componentes
        $this->edges[] = [
            'source' => $source,
            'destination' => $destination,
            'weight' => $weight
        ];
    }

    /**
     * Exibe a representação das arestas do grafo.
     */
    public function printGraph()
    {
        echo "\n--- Grafo Digitado ---\n";
        echo "Número de Vértices: " . $this->vertices . "\n";
        echo "Arestas (Origem -> Destino [Peso]):\n";
        if (empty($this->edges)) {
            echo "  Nenhuma aresta.\n";
        } else {
            foreach ($this->edges as $edge) {
                echo "  " . $edge['source'] . " -> " . $edge['destination'] . " [" . $edge['weight'] . "]\n";
            }
        }
        echo "----------------------\n";
    }

    /**
     * Implementa o algoritmo de Bellman-Ford.
     * @param int $startNode O vértice de onde o cálculo do caminho mais curto deve começar.
     * @return array|false Um array associativo contendo 'distances' e 'predecessors',
     * ou false se um ciclo de peso negativo for detectado.
     */
    public function bellmanFord(int $startNode)
    {
        // Passo 1: Inicializar distâncias e predecessores.
        $distances = array_fill(0, $this->vertices, PHP_INT_MAX);
        $predecessors = array_fill(0, $this->vertices, -1); // Armazena o predecessor de cada vértice no caminho mais curto

        $distances[$startNode] = 0; // A distância do nó de origem para ele mesmo é 0

        // Passo 2: Relaxar todas as arestas V-1 vezes.
        for ($i = 0; $i < $this->vertices - 1; $i++) {
            foreach ($this->edges as $edge) {
                $u = $edge['source'];
                $v = $edge['destination'];
                $weight = $edge['weight'];

                if ($distances[$u] != PHP_INT_MAX && $distances[$u] + $weight < $distances[$v]) {
                    $distances[$v] = $distances[$u] + $weight;
                    $predecessors[$v] = $u; // Define 'u' como predecessor de 'v'
                }
            }
        }

        // Passo 3: Detectar ciclos de peso negativo.
        foreach ($this->edges as $edge) {
            $u = $edge['source'];
            $v = $edge['destination'];
            $weight = $edge['weight'];

            if ($distances[$u] != PHP_INT_MAX && $distances[$u] + $weight < $distances[$v]) {
                echo "O grafo contém um **ciclo de peso negativo** alcançável a partir do nó de origem.\n";
                echo "Os caminhos mais curtos não podem ser determinados.\n";
                return false;
            }
        }

        // Se nenhum ciclo negativo for detectado, retorna as distâncias e os predecessores.
        return [
            'distances' => $distances,
            'predecessors' => $predecessors
        ];
    }

    /**
     * Exibe as distâncias calculadas e reconstrói os caminhos mais curtos.
     * @param array $result O array associativo contendo 'distances' e 'predecessors'.
     * @param int $startNode O nó de origem.
     */
    public function printShortestPaths(array $result, int $startNode)
    {
        $distances = $result['distances'];
        $predecessors = $result['predecessors'];

        echo "\n--- Resultados do Bellman-Ford ---\n";
        echo "Nó de Origem: " . $startNode . "\n";

        for ($i = 0; $i < $this->vertices; $i++) {
            echo "\nPara Vértice " . $i . ":\n";
            $dist = ($distances[$i] == PHP_INT_MAX) ? "INF" : $distances[$i];
            echo "  Distância: " . $dist . "\n";

            if ($i == $startNode) {
                echo "  Caminho: " . $startNode . " (Origem)\n";
                continue;
            }

            if ($distances[$i] == PHP_INT_MAX) {
                echo "  Caminho: Inatingível\n";
                continue;
            }

            // Reconstruir o caminho
            $path = [];
            $current = $i;
            // Percorre os predecessores até chegar ao nó de origem ou um predecessor inválido (-1)
            while ($current != -1 && $current != $startNode) {
                array_unshift($path, $current); // Adiciona o vértice ao início do array do caminho
                $current = $predecessors[$current];
            }

            // Se o loop terminou e current não é o startNode, significa um problema no caminho (ex: unreachable de um ciclo)
            // Ou se o caminho não começou do startNode e nao é o startNode
            if ($current == -1 && $i != $startNode) { // Chegou ao -1 sem encontrar o startNode
                echo "  Caminho: Inatingível ou problema de ciclo (não deveria ocorrer se não há ciclo negativo)\n";
            } else {
                array_unshift($path, $startNode); // Adiciona o nó de origem ao início do caminho
                echo "  Caminho: " . implode(" -> ", $path) . "\n";
            }
        }
        echo "---------------------------------\n";
    }
}

/**
 * Função auxiliar para ler uma linha da entrada padrão (STDIN).
 * @param string $prompt A mensagem a ser exibida para o usuário.
 * @return string A linha lida da entrada.
 */
function readInput(string $prompt): string
{
    echo $prompt;
    return trim(fgets(STDIN));
}

/**
 * Função para obter um número inteiro válido da entrada do usuário.
 * @param string $prompt A mensagem a ser exibida para o usuário.
 * @param int $min O valor mínimo permitido.
 * @return int O número inteiro lido.
 */
function getIntInput(string $prompt, int $min = 0): int
{
    while (true) {
        $input = readInput($prompt);
        if (is_numeric($input) && intval($input) >= $min) {
            return intval($input);
        } else {
            echo "Entrada inválida. Por favor, digite um número inteiro maior ou igual a $min.\n";
        }
    }
}

// --- Lógica Principal para Input do Usuário ---

echo "Bem-vindo ao calculador de grafo Bellman-Ford!\n";
echo "Os vértices são indexados a partir de 0.\n\n";

// 1. Obter o número de vértices
$numVertices = getIntInput("Digite o número de vértices no grafo: ", 1);

$graph = new Graph($numVertices);

// 2. Obter o número de arestas
$numEdges = getIntInput("Digite o número de arestas no grafo: ", 0);

echo "\nAgora, insira as arestas. Para cada aresta, digite 'origem destino peso' (ex: 0 1 5).\n";
echo "Os vértices devem estar no intervalo [0, " . ($numVertices - 1) . "].\n";

// 3. Obter as informações de cada aresta
for ($i = 0; $i < $numEdges; $i++) {
    while (true) {
        $edgeInput = readInput("Aresta " . ($i + 1) . ": ");
        $parts = explode(' ', $edgeInput);

        if (count($parts) == 3 && is_numeric($parts[0]) && is_numeric($parts[1]) && is_numeric($parts[2])) {
            $source = intval($parts[0]);
            $destination = intval($parts[1]);
            $weight = intval($parts[2]);

            // Validação dos vértices
            if ($source >= 0 && $source < $numVertices && $destination >= 0 && $destination < $numVertices) {
                $graph->addEdge($source, $destination, $weight);
                break; // Aresta válida, sai do loop interno
            } else {
                echo "Erro: Vértices fora do intervalo válido [0, " . ($numVertices - 1) . "]. Tente novamente.\n";
            }
        } else {
            echo "Formato inválido. Use 'origem destino peso' (ex: 0 1 5).\n";
        }
    }
}

// Exibir o grafo digitado
$graph->printGraph();

// 4. Obter o nó de origem para o cálculo
$startNode = getIntInput("\nDigite o nó de origem para o cálculo do Bellman-Ford: ", 0);
while ($startNode >= $numVertices) {
    echo "Nó de origem inválido. Deve estar no intervalo [0, " . ($numVertices - 1) . "].\n";
    $startNode = getIntInput("Digite o nó de origem para o cálculo do Bellman-Ford: ", 0);
}

// 5. Executar o algoritmo e exibir os resultados
$bellmanFordResult = $graph->bellmanFord($startNode);

if ($bellmanFordResult !== false) {
    $graph->printShortestPaths($bellmanFordResult, $startNode);
}

?>