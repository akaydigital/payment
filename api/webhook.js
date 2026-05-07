module.exports = async (req, res) => {

    console.log('Webhook Midtrans');

    console.log(req.body);

    res.status(200).json({
        success: true
    });

};
