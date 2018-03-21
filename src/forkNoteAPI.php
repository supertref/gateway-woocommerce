<?php

class ForkNoteWalletd
{
    private $server;

    public function __construct($server)
    {
        $this->server = $server;
    }

    private function apiCall($req)
    {
        static $ch = null;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $url = $this->server . '/json_rpc';
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $res = curl_exec($ch);
        if ($res === false) {
            throw new Exception('Could not get reply: '.curl_error($ch));
        }
        $result = json_decode($res, true);

        // Check for Error
        if (!isset($result['result'])) {
            $e =  "API call to '" . $req['method'] . "' returned ";
            if (isset($result['error'])) {
                $e .= "Error(" . $result['error']['code'] . "): " . $result['error']['message'] . PHP_EOL;
            } else {
                $e .= "Unknown Error: " . print_r($result, true) . PHP_EOL;
            }
            throw new Exception($e);
            return false;
        }
        return $result;
    }

    public function reset($viewSecretKey = false)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "reset";
        if ($viewSecretKey) {
            $args["params"]["viewSecretKey"] = $viewSecretKey;
        }
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }
    

    public function save()
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "save";
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getViewKey()
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getViewKey";
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getSpendKeys($address)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getSpendKeys";
        $args["params"]["address"] = $address;
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getStatus()
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getStatus";
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getAddresses()
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getAddresses";
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function createAddress($publicSpendKey = false, $secretSpendKey = false)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "createAddress";
        if ($secretSpendKey) {
            $args["params"]["spendSecretKey"] = $secretSpendKey;
        } elseif ($publicSpendKey) {
            $args["params"]["spendPublicKey"] = $publicSpendKey;
        }
        print_r($args);
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function deleteAddress($address)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "deleteAddress";
        $args["params"]["address"] = $address;
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }


    public function getBalance($address = false)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getBalance";
        if ($address) {
            $args["params"]["address"] = $address;
        }
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getBlockHashes($firstBlockIndex, $blockCount)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getBlockHashes";
        $args["params"]["firstBlockIndex"] = $firstBlockIndex;
        $args["params"]["blockCount"] = $blockCount;
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getTransactionHashes($firstBlockIndex=false, $firstblockHash=false, $blockCount, $paymentId=false, $addresses=false)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getTransactionHashes";
        if ($firstBlockIndex) {
            $args["params"]["firstBlockIndex"] = $firstBlockIndex;
        } else {
            if ($firstblockHash) {
                $args["params"]["blockHash"] = $firstblockHash;
            } else {
                return;
            }
        }
        $args["params"]["blockCount"] = $blockCount;
        if ($paymentId) {
            $args["params"]["paymentId"] = $paymentId;
        }
        if ($addresses) {
            $args["params"]["addresses"] = $addresses;
        }
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getTransactions($firstBlockIndex=false, $firstblockHash=false, $blockCount, $paymentId=false, $addresses=false)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getTransactions";
        if ($firstBlockIndex) {
            $args["params"]["firstBlockIndex"] = $firstBlockIndex;
        } else {
            if ($firstblockHash) {
                $args["params"]["blockHash"] = $firstblockHash;
            } else {
                return;
            }
        }
        $args["params"]["blockCount"] = $blockCount;
        if ($paymentId) {
            $args["params"]["paymentId"] = $paymentId;
        }
        if ($addresses) {
            $args["params"]["addresses"] = $addresses;
        }
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getUnconfirmedTransactionHashes($addresses=false)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getUnconfirmedTransactionHashes";
        if ($addresses) {
            $args["params"]["addresses"] = $addresses;
        }
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function getTransaction($transactionHash)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "getTransaction";
        $args["params"]["transactionHash"] = $transactionHash;
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function sendTransaction($fromAddresses=false, $transfers, $paymentId=false, $anonymity=6, $fee=1000000, $changeAddress=false, $unlockTime=false, $extra=false)
    {
        $args = array();
        $args["jsonrpc"] = "2.0";
        $args["id"] = "test";
        $args["method"] = "sendTransaction";
        if ($fromAddresses) {
            $args["params"]["addresses"] = $fromAddresses;
        }
        $args["params"]["transfers"] = $transfers;
        if ($paymentId) {
            $args["params"]["paymentId"] = $paymentId;
        }
        $args["params"]["anonymity"] = $anonymity;
        $args["params"]["fee"] = $fee;
        if ($changeAddress) {
            $args["params"]["changeAddress"] = $changeAddress;
        }
        if ($unlockTime) {
            $args["params"]["unlockTime"] = $unlockTime;
        }
        if ($extra) {
            $args["params"]["extra"] = $extra;
        }
        $result = $this->apiCall($args);
        if ($result) {
            return $result['result'];
        }
    }

    public function makePaymentId()
    {
        return bin2hex(openssl_random_pseudo_bytes(32));
    }
}
