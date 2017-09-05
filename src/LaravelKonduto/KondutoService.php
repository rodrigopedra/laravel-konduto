<?php

namespace RodrigoPedra\LaravelKonduto;

use Exception;
use Konduto\Core\Konduto;
use Konduto\Models\Order;
use Illuminate\Http\Request;
use Psr\Log\LoggerInterface;
use InvalidArgumentException;

class KondutoService
{
    /** @see http://ajuda.konduto.com/article/114-entendendo-os-status-dos-pedidos */
    const ORDER_STATUS_APPROVED       = 'approved';
    const ORDER_STATUS_PENDING        = 'pending';
    const ORDER_STATUS_DECLINED       = 'declined';
    const ORDER_STATUS_NOT_AUTHORIZED = 'not_authorized';
    const ORDER_STATUS_CANCELLED      = 'cancelled';
    const ORDER_STATUS_FRAUD          = 'fraud';
    const ORDER_STATUS_NOT_ANALYZED   = 'not_analyzed';

    private static $updateStatusList = [
        self::ORDER_STATUS_APPROVED,
        self::ORDER_STATUS_DECLINED,
        self::ORDER_STATUS_NOT_AUTHORIZED,
        self::ORDER_STATUS_CANCELLED,
        self::ORDER_STATUS_FRAUD,
    ];

    /** @var Request */
    private $request;

    /** @var string */
    private $publicKey;

    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Request $request,
        $publicKey,
        $privateKey,
        LoggerInterface $logger = null
    ) {
        $this->request   = $request;
        $this->publicKey = $publicKey;
        $this->logger    = $logger;

        Konduto::setApiKey( $privateKey );
    }

    public function getPublicKey()
    {
        return $this->publicKey;
    }

    public function getOrigin()
    {
        if ($this->request->hasSession()) {
            return 'WEB';
        }

        return 'API';
    }

    public function getIp()
    {
        return $this->request->getClientIp();
    }

    /**
     * Método para envio de pedidos e retorno do status
     *
     * @param  Order $order
     *
     * @return Order
     * @throws Exception
     */
    public function analysis( Order $order )
    {
        $this->log( '[KONDUTO] REQUEST: analysis', [ $order ] );

        try {
            $response = Konduto::analyze( $order );
        } catch ( Exception $exception ) {
            $this->log( '[KONDUTO] ERROR: analysis', [ $exception->getMessage() ] );

            throw $exception;
        }

        $this->log( '[KONDUTO] RESPONSE: analysis', [ $response ] );

        return $response;
    }

    /**
     * Método para envio de pedidos sem análise
     *
     * @param  Order $order
     *
     * @return Order
     * @throws Exception
     */
    public function sendOrder( Order $order )
    {
        $this->log( '[KONDUTO] REQUEST: sendOrder', [ $order ] );

        try {
            $response = Konduto::sendOrder( $order );
        } catch ( Exception $exception ) {
            $this->log( '[KONDUTO] ERROR: sendOrder', [ $exception->getMessage() ] );

            throw $exception;
        }

        $this->log( '[KONDUTO] RESPONSE: sendOrder', [ $response ] );

        return $response;
    }

    /**
     * Consulta o andamento de uma análise
     *
     * @param  string $orderId
     *
     * @return Order
     * @throws Exception
     */
    public function getOrder( $orderId )
    {
        $this->log( '[KONDUTO] REQUEST: getOrder', [ $orderId ] );

        try {
            $response = Konduto::getOrder( $orderId );
        } catch ( Exception $exception ) {
            $this->log( '[KONDUTO] ERROR: getOrder', [ $exception->getMessage() ] );

            throw $exception;
        }

        $this->log( '[KONDUTO] RESPONSE: getOrder', [ $response ] );

        return $response;
    }

    /**
     * Método para atualizar o pedido com o status do pagamento
     *
     * @param  string $orderId
     * @param  string $newStatusCode
     * @param  string $notes
     *
     * @return bool
     * @throws Exception
     */
    public function updateOrderStatus( $orderId, $newStatusCode, $notes = '' )
    {
        if (!in_array( $newStatusCode, self::$updateStatusList )) {
            throw new InvalidArgumentException( sprintf( 'Invalid new status code (%s)', $newStatusCode ) );
        }

        $this->log( '[KONDUTO] REQUEST: updateOrderStatus', [ $orderId, $newStatusCode, $notes ] );

        try {
            $response = Konduto::updateOrderStatus( $orderId, $newStatusCode, $notes );
        } catch ( Exception $exception ) {
            $this->log( '[KONDUTO] ERROR: updateOrderStatus', [ $exception->getMessage() ] );

            throw $exception;
        }

        $this->log( '[KONDUTO] RESPONSE: updateOrderStatus', [ $response ? 'success' : 'failed' ] );

        return $response;
    }

    private function log( $message, array $context = [] )
    {
        if (is_null( $this->logger )) {
            return;
        }

        $this->logger->debug( $message, $context );
    }
}
