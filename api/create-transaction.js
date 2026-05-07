const midtransClient = require('midtrans-client');

module.exports = async (req, res) => {

    if (req.method !== 'POST') {
        return res.status(405).json({
            message: 'Method not allowed'
        });
    }

    try {

        const {
            product,
            amount
        } = req.body;

        let snap = new midtransClient.Snap({
            isProduction: false,
            serverKey: process.env.MIDTRANS_SERVER_KEY,
            clientKey: process.env.MIDTRANS_CLIENT_KEY
        });

        const orderId = 'AKAY-' + Date.now();

        const parameter = {

            transaction_details: {
                order_id: orderId,
                gross_amount: amount
            },

            item_details: [
                {
                    id: 'ITEM1',
                    price: amount,
                    quantity: 1,
                    name: product
                }
            ],

            customer_details: {
                first_name: 'Customer',
                email: 'customer@email.com',
                phone: '08123456789'
            }

        };

        const transaction = await snap.createTransaction(parameter);

        res.status(200).json({
            token: transaction.token
        });

    } catch (error) {

        console.log(error);

        res.status(500).json({
            error: error.message
        });

    }

};
