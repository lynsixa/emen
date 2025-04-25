import { User } from "../../Domain/entities/User";
import { AuthRepository } from '../../Domain/repositories/AuthRepository';
import { ApiGero } from "../sources/remote/api/ApiGero";
import { ResponseApiGero } from "../sources/remote/models/ResponseApiGero";
import { AxiosError } from "axios";

export class AuthRepositoryImpl implements AuthRepository {
    async register(user:User): Promise<ResponseApiGero> {
        try{
            const response = await ApiGero.post<ResponseApiGero>("/users/create", user);
            return Promise.resolve(response.data);

        } catch (error){
            let e = (error as AxiosError);
            console.log("error" + JSON.stringify(e.response?.data));
            const apiError:ResponseApiGero = JSON.parse(JSON.stringify(e.response?.data));
            return Promise.resolve(apiError);
            
        }
    }

    async login(documento: string, contrasena: string): Promise<ResponseApiGero> {
        try {
            const response = await ApiGero.post<ResponseApiGero>('/api/users/login', {
                documento: documento, contrasena: contrasena});
            return Promise.resolve(response.data);

        } catch (error) {
            let e = (error as AxiosError);
            console.log("error" + JSON.stringify(e.response?.data));
            const apiError: ResponseApiGero = JSON.parse(JSON.stringify(e.response?.data)); 
            return Promise.resolve(apiError);
        }
    }

    async logout(): Promise<ResponseApiGero> {
        try {
            const response = await ApiGero.post<ResponseApiGero>('/api/users/logout');
            return Promise.resolve(response.data);
        } catch (error) {
            let e = (error as AxiosError);
            console.log("error" + JSON.stringify(e.response?.data));
            const apiError: ResponseApiGero = JSON.parse(JSON.stringify(e.response?.data));
            return Promise.resolve(apiError);
        }
    }
}



