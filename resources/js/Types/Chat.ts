import { IUser } from "./User";

export interface IChat{
    chat_id: number;
    other_user: number;
    last_message: IMessage;
    other_user_info: IUser;
}

export interface IMessage{
    chat_id: number;
    from_user_id: number;
    to_user_id: number;
    message: string;
    created_at: string;
}