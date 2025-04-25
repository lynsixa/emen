import axios from 'axios';

const ApiGero = axios.create({
    baseURL: 'http://192.168.20.113:3000/',
    headers: {
        'Content-Type': 'application/json'
    }
});


//VENTAS

export const getVentas = async () => {
    const response = await ApiGero.get('/ventas');
    return response.data;
}

export const postVentas = async (ventas: any) => {
    const response = await ApiGero.post('/ventas', ventas);
    return response.data;
}



//PRODUCTOS

export const getTopProducts = async () => {
    const response = await ApiGero.get('/topproducts');
    return response.data;
};

export const getProduct = async (id: string, product: any) => {
    const response = await ApiGero.put(`/products/${id}`, product);
    return response.data;
};
export const createProduct = async (product: any) => {
    const response = await ApiGero.post('/products', product);
    return response.data;
};
export const updateProduct = async (id: string, product: any) => {
    const response = await ApiGero.put(`/products/${id}`, product);
    return response.data;

};
export const deleteProduct = async (id: string) => {
    const response = await ApiGero.delete(`/products/${id}`);
    return response.data;
};

//PROVEEDORES

export const getProveedores = async () => {
    const response = await ApiGero.get('/proveedores');
    return response.data;
};


export {ApiGero}