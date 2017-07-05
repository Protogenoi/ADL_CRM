<?php

class TotalExpectedWithDatesModal {

    protected $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getTotalExpectedWithDates($datefrom, $dateto) {

        $stmt = $this->pdo->prepare("SELECT 
    SUM(commission) AS commission
FROM
    client_policy
WHERE
DATE(submitted_date) BETWEEN :datefrom AND :dateto
        AND insurer = 'Legal and General'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'
        OR DATE(sale_date) BETWEEN :datefrom2 AND :dateto2
        AND insurer = 'Legal and General'
        AND client_policy.policystatus NOT LIKE '%CANCELLED%'
        AND client_policy.policystatus NOT IN ('Clawback' , 'SUBMITTED-NOT-LIVE',
        'DECLINED',
        'On hold')
        AND client_policy.policy_number NOT LIKE '%DU%'");
        $stmt->bindParam(':datefrom', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto', $dateto, PDO::PARAM_STR);
                $stmt->bindParam(':datefrom2', $datefrom, PDO::PARAM_STR);
        $stmt->bindParam(':dateto2', $dateto, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>