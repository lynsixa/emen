import { User } from "../entities/User";
import { ResponseApiGero } from "../../Data/sources/remote/models/ResponseApiGero";
import { LoginScreen } from '../../Presentation/views/home/login';

export interface AuthRepository{
    register(user: User): Promise<ResponseApiGero>;
    login(correo: string, contrasena: string): Promise<ResponseApiGero>;
    logout(): Promise<ResponseApiGero>;
}