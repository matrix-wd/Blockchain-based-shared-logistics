pragma solidity >=0.4.22 <0.6.0;
pragma experimental ABIEncoderV2;
contract Order {
    // conveyance order
    struct conveyanceOrder {
        uint128 orderId;
        address payable buyer;
        address payable seller;
        uint128 conveyanceId;
        uint amount; // amount
        uint8 status; // 0 unfinished 1 finished 2 refund
        uint created_at; // order time
    }
    
    // warehouse order
    struct warehouseOrder {
        uint128 orderId;
        address payable buyer;
        address payable seller;
        uint128 warehouseId;
        uint amount; // amount
        uint8 status; // 0 unfinished 1 finished 2 refund
        uint created_at; // order time
    }
    
    // event
    event EtherChange(
        address user,
        uint8 types, // 0 => pay  1 => get 
        uint amount
    );
    // orders
    conveyanceOrder[] public conveyanceOrders;
    warehouseOrder[] public warehouseOrders;
    
    //mapping orderId => Item
    mapping(uint128 => conveyanceOrder) orderIdToConveyance;
    mapping(uint128 => warehouseOrder) orderIdToWarehouse;
    
    
    address payable private admin; // admin address
    
    // set admin address
    constructor() public {
        admin = msg.sender;
    }
    
    // add the conveyance order
    function addConveyance(uint128 orderId, address payable seller, uint128 conveyanceId, uint amount) public payable {
        require(msg.value == amount,
            'The Ether is not correct'
        );
        conveyanceOrder memory newItem = conveyanceOrder(orderId, msg.sender, seller, conveyanceId,amount, 0, now);
        orderIdToConveyance[orderId] = newItem;
        emit EtherChange(msg.sender, 0, msg.value);
        conveyanceOrders.push(newItem);
    }
    
    // add the warehouse order
    function addWarehouse(uint128 orderId, address payable seller, uint128 warehouseId, uint amount) public payable {
        require(msg.value == amount,
            'The Ether is not correct'
        );
        warehouseOrder memory newItem = warehouseOrder(orderId, msg.sender, seller, warehouseId, amount, 0, now);
        orderIdToWarehouse[orderId] = newItem;
        emit EtherChange(msg.sender, 0, msg.value);
        warehouseOrders.push(newItem);
    }
    
    // review conveyance order
    function reviewConveyanceOrder(uint128 orderId) public {
        conveyanceOrder memory item = orderIdToConveyance[orderId];
        require(msg.sender == item.buyer, 
            'Permission denied'
        );
        if(item.status == 0) {
            item.seller.transfer(item.amount);
            emit EtherChange(item.seller, 1, item.amount);
            for(uint128 i = 0; i < conveyanceOrders.length; i++) {
                if(conveyanceOrders[i].orderId == orderId) {
                    conveyanceOrders[i].status = 1;
                }
            }
        }
    }
    
    // review warehouse order    
    function reviewWarehouseOrder(uint128 orderId) public {
        warehouseOrder memory item = orderIdToWarehouse[orderId];
        require(msg.sender == item.buyer,
            'Permission denied'
        );
        if(item.status == 0) {
            item.seller.transfer(item.amount);
            emit EtherChange(item.seller, 1, item.amount);
            for(uint128 i = 0; i < warehouseOrders.length; i++) {
                if(warehouseOrders[i].orderId == orderId) {
                    warehouseOrders[i].status = 1;
                }
            }
        }
    }
    
    // refund conveyance order
    function refundConveyanceOrder(uint128 orderId) public {
        conveyanceOrder memory item = orderIdToConveyance[orderId];
        require(msg.sender == item.seller,
            'Permission denied'
        );
        if(item.status == 0) {
            item.buyer.transfer(item.amount);
            emit EtherChange(item.buyer, 1, item.amount);
            for(uint128 i = 0; i < conveyanceOrders.length; i++) {
                if(conveyanceOrders[i].orderId == orderId) {
                    conveyanceOrders[i].status = 2;
                }
            }
        }
    }
    
    // refund warehouse order
    function refundWarehouseOrder(uint128 orderId) public {
        warehouseOrder memory item = orderIdToWarehouse[orderId];
        require(msg.sender == item.seller,
            'Permission denied'
        );
        if(item.status == 0) {
            item.buyer.transfer(item.amount);
            emit EtherChange(item.buyer, 1, item.amount);
            for(uint128 i = 0; i < warehouseOrders.length; i++) {
                if(warehouseOrders[i].orderId == orderId) {
                    warehouseOrders[i].status = 2;
                }
            }
        }
    }

    // get all conveyance order info
    function getConveyanceData() public view returns(conveyanceOrder[] memory) {
        return conveyanceOrders;
    }
    
    // get all warehouse order info
    function getWarehouseData() public view returns(warehouseOrder[] memory) {
        return warehouseOrders;
    }

}


