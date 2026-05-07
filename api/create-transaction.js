const midtransClient = require('midtrans-client');

module.exports = async (req, res) => {

    if (req.method !== 'POST') {
        return res.status(405).json({
            message: 'Method not allowed'
        });
    }

    try {

        let snap = new midtransClient.Snap({
            isProduction: false,
            serverKey: process.env.MIDTRANS_SERVER_KEY,
            clientKey: process.env.MIDTRANS_CLIENT_KEY
        });

        const orderId = 'AKAY-' + Date.now();

        const parameter = {

            transaction_details: {
                order_id: orderId,
                gross_amount: 500000
            },

            customer_details: {
                first_name: 'Budi',
                email: 'budi@gmail.com',
                phone: '08123456789'
            },

            item_details: [
                {
                    id: 'ITEM1',
                    price: 500000,
                    quantity: 1,
                    name: 'Jasa Website'
                }
            ]

        };

        const transaction = await snap.createTransaction(parameter);

        res.status(200).json({
            token: transaction.token
        });

    } catch (error) {

        res.status(500).json({
            error: error.message
        });

    }

};
