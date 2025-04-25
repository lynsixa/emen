import { UserLocalRepositoryImpl } from "../../../Data/repositories/UserLocalRepository";
import { AuthRepositoryImpl } from "../../../Data/repositories/AuthRepository";

import { User } from "../../entities/User";
const { remove } = new UserLocalRepositoryImpl();
const { logout } = new AuthRepositoryImpl();

export const RemoveUserLocalUseCase = async () => {
    await logout();
    return await remove();
}