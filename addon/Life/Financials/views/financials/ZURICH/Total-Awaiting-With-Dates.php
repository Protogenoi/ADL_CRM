
    <?php foreach ($ZURICH_TotalAwaitingWithDatesList as $ZURICH_TotalAwaitingWithDatesList_Resuts): ?>


        <?php
                $AWAITING_WITH_DATES_COMMISSION = $ZURICH_TotalAwaitingWithDatesList_Resuts['commission'];
                
                            $simply_AWAITING_SUM = ($simply_biz / 100) * $AWAITING_WITH_DATES_COMMISSION;
                            $ZURICH_ADL_AWAITING_SUM = $AWAITING_WITH_DATES_COMMISSION - $simply_AWAITING_SUM;
                            
                            $ZURICH_ADL_AWAITING_SUM_DATES_FORMAT = number_format($AWAITING_WITH_DATES_COMMISSION, 2);
                            $simply_AWAITING_SUM_FORMAT = number_format($simply_AWAITING_SUM, 2);
                            $ZURICH_ADL_AWAITING_SUM_FORMAT = number_format($ZURICH_ADL_AWAITING_SUM, 2);
                            
                        ?>

    <?php endforeach ?>
