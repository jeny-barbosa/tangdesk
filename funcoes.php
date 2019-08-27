<?php

require 'conexao.php';

//COLABORADOR
$sQueryColaborador = "
      SELECT ID, NOME
        FROM COLABORADOR
        ORDER BY NOME
      ";
$sListColaborador  = mysqli_query($conn, $sQueryColaborador);

//HORAS APONTADAS
$sSomaHoraApontada = "
      SELECT ID_COLABORADOR,
        SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_APONTADA))) AS TOTAL_HORAS
       FROM MOVIDESK
       JOIN COLABORADOR
         ON COLABORADOR = MOVIDESK.ID_COLABORADOR
       WHERE MOVIDESK.ID = %d";

//$sHoraApontada = mysqli_fetch_array(printf($sSomaHoraApontada['TOTAL_HORAS']));

//echo $sHoraApontada;
//HORAS TRABALHADAS
$sSomaHoraTrabalhada = "
      SELECT ID_COLABORADOR,
        SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))) AS TOTAL_HORAS
       FROM MOVIDESK
       JOIN COLABORADOR
         ON COLABORADOR = MOVIDESK.ID_COLABORADOR
       WHERE MOVIDESK.ID = %d";

$sListHoraTrabalhada = mysqli_query($conn, $sSomaHoraTrabalhada);

//DIFERENÇA ENTRE HORAS
$sHoraDiferenca  = "
      SELECT
        @tot1:= SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_TRABALHADA))),
        @tot2:= SEC_TO_TIME(SUM(TIME_TO_SEC(HORA_APONTADA))),
        (TIMEDIFF(@tot2,@tot1)) AS DIFERENCA
       FROM MOVIDESK
      ";
$sTotalDiferenca = mysqli_query($conn, $sHoraDiferenca);

//MÊS
$sMesCorrespondente = "
    SELECT DATA_PONTO,
      CASE
        WHEN MONTH(DATA_PONTO) = '01' THEN 'Janeiro'
        WHEN MONTH(DATA_PONTO) = '02' THEN 'Fevereiro'
        WHEN MONTH(DATA_PONTO) = '03' THEN 'Março'
        WHEN MONTH(DATA_PONTO) = '04' THEN 'Abril'
        WHEN MONTH(DATA_PONTO) = '05' THEN 'Maio'
        WHEN MONTH(DATA_PONTO) = '06' THEN 'Junho'
        WHEN MONTH(DATA_PONTO) = '07' THEN 'Julho'
        WHEN MONTH(DATA_PONTO) = '08' THEN 'Agosto'
        WHEN MONTH(DATA_PONTO) = '09' THEN 'Setembro'
        WHEN MONTH(DATA_PONTO) = '10' THEN 'Outubro'
        WHEN MONTH(DATA_PONTO) = '11' THEN 'Novembro'
        WHEN MONTH(DATA_PONTO) = '12' THEN 'Dezembro'
      ELSE 'Mês Inválido'
     END AS MES
     FROM TANGERINO
     GROUP BY MES
    ";
$sMes  = mysqli_query($conn, $sMesCorrespondente);

//TABELA TANGERINO
$sQueryTang = "
      SELECT
        HORA_PONTO,
        DATA_PONTO
       FROM TANGERINO
       GROUP BY DATA_PONTO
";
$sListTangerino = mysqli_query($conn, $sQueryTang);


//CHAMADOS MOVIDESK
$sQueryChamado = "
       SELECT
        TICKET, 
        CHAMADO,
        DATA_PONTO,
        HORA_INICIO,
        HORA_FIM,
        HORA_APONTADA,
        HORA_TRABALHADA
       FROM MOVIDESK";

$sResultado = mysqli_query($conn, $sQueryChamado);


