export default [
    {
        "constant": false,
        "inputs": [
            {
                "name": "orderId",
                "type": "uint128"
            }
        ],
        "name": "refundConveyanceOrder",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [
            {
                "name": "",
                "type": "uint256"
            }
        ],
        "name": "warehouseOrders",
        "outputs": [
            {
                "name": "orderId",
                "type": "uint128"
            },
            {
                "name": "buyer",
                "type": "address"
            },
            {
                "name": "seller",
                "type": "address"
            },
            {
                "name": "warehouseId",
                "type": "uint128"
            },
            {
                "name": "amount",
                "type": "uint256"
            },
            {
                "name": "status",
                "type": "uint8"
            },
            {
                "name": "created_at",
                "type": "uint256"
            }
        ],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [
            {
                "name": "orderId",
                "type": "uint128"
            }
        ],
        "name": "refundWarehouseOrder",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "getConveyanceData",
        "outputs": [
            {
                "components": [
                    {
                        "name": "orderId",
                        "type": "uint128"
                    },
                    {
                        "name": "buyer",
                        "type": "address"
                    },
                    {
                        "name": "seller",
                        "type": "address"
                    },
                    {
                        "name": "conveyanceId",
                        "type": "uint128"
                    },
                    {
                        "name": "amount",
                        "type": "uint256"
                    },
                    {
                        "name": "status",
                        "type": "uint8"
                    },
                    {
                        "name": "created_at",
                        "type": "uint256"
                    }
                ],
                "name": "",
                "type": "tuple[]"
            }
        ],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [
            {
                "name": "",
                "type": "uint256"
            }
        ],
        "name": "conveyanceOrders",
        "outputs": [
            {
                "name": "orderId",
                "type": "uint128"
            },
            {
                "name": "buyer",
                "type": "address"
            },
            {
                "name": "seller",
                "type": "address"
            },
            {
                "name": "conveyanceId",
                "type": "uint128"
            },
            {
                "name": "amount",
                "type": "uint256"
            },
            {
                "name": "status",
                "type": "uint8"
            },
            {
                "name": "created_at",
                "type": "uint256"
            }
        ],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [
            {
                "name": "orderId",
                "type": "uint128"
            }
        ],
        "name": "reviewConveyanceOrder",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [
            {
                "name": "orderId",
                "type": "uint128"
            }
        ],
        "name": "reviewWarehouseOrder",
        "outputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [
            {
                "name": "orderId",
                "type": "uint128"
            },
            {
                "name": "seller",
                "type": "address"
            },
            {
                "name": "warehouseId",
                "type": "uint128"
            },
            {
                "name": "amount",
                "type": "uint256"
            }
        ],
        "name": "addWarehouse",
        "outputs": [],
        "payable": true,
        "stateMutability": "payable",
        "type": "function"
    },
    {
        "constant": false,
        "inputs": [
            {
                "name": "orderId",
                "type": "uint128"
            },
            {
                "name": "seller",
                "type": "address"
            },
            {
                "name": "conveyanceId",
                "type": "uint128"
            },
            {
                "name": "amount",
                "type": "uint256"
            }
        ],
        "name": "addConveyance",
        "outputs": [],
        "payable": true,
        "stateMutability": "payable",
        "type": "function"
    },
    {
        "constant": true,
        "inputs": [],
        "name": "getWarehouseData",
        "outputs": [
            {
                "components": [
                    {
                        "name": "orderId",
                        "type": "uint128"
                    },
                    {
                        "name": "buyer",
                        "type": "address"
                    },
                    {
                        "name": "seller",
                        "type": "address"
                    },
                    {
                        "name": "warehouseId",
                        "type": "uint128"
                    },
                    {
                        "name": "amount",
                        "type": "uint256"
                    },
                    {
                        "name": "status",
                        "type": "uint8"
                    },
                    {
                        "name": "created_at",
                        "type": "uint256"
                    }
                ],
                "name": "",
                "type": "tuple[]"
            }
        ],
        "payable": false,
        "stateMutability": "view",
        "type": "function"
    },
    {
        "inputs": [],
        "payable": false,
        "stateMutability": "nonpayable",
        "type": "constructor"
    },
    {
        "anonymous": false,
        "inputs": [
            {
                "indexed": false,
                "name": "user",
                "type": "address"
            },
            {
                "indexed": false,
                "name": "types",
                "type": "uint8"
            },
            {
                "indexed": false,
                "name": "amount",
                "type": "uint256"
            }
        ],
        "name": "EtherChange",
        "type": "event"
    }
]